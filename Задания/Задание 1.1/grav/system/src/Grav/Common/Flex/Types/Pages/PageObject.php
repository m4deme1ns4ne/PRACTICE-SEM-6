<?php

declare(strict_types=1);

/**
 * @package    Grav\Common\Flex
 *
 * @copyright  Copyright (C) 2015 - 2020 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\Flex\Types\Pages;

use Grav\Common\Data\Blueprint;
use Grav\Common\Flex\Traits\FlexGravTrait;
use Grav\Common\Flex\Traits\FlexObjectTrait;
use Grav\Common\Grav;
use Grav\Common\Flex\Types\Pages\Traits\PageContentTrait;
use Grav\Common\Flex\Types\Pages\Traits\PageLegacyTrait;
use Grav\Common\Flex\Types\Pages\Traits\PageRoutableTrait;
use Grav\Common\Flex\Types\Pages\Traits\PageTranslateTrait;
use Grav\Common\Language\Language;
use Grav\Common\Page\Interfaces\PageInterface;
use Grav\Common\Page\Pages;
use Grav\Common\Utils;
use Grav\Framework\Filesystem\Filesystem;
use Grav\Framework\Flex\FlexObject;
use Grav\Framework\Flex\Interfaces\FlexObjectInterface;
use Grav\Framework\Flex\Pages\FlexPageObject;
use Grav\Framework\Route\Route;
use Grav\Framework\Route\RouteFactory;
use Grav\Plugin\Admin\Admin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class GravPageObject
 * @package Grav\Plugin\FlexObjects\Types\GravPages
 *
 * @property string $name
 * @property string $route
 * @property string $folder
 * @property int|false $order
 * @property string $template
 * @property string $language
 */
class PageObject extends FlexPageObject
{
    use FlexGravTrait;
    use FlexObjectTrait;
    use PageContentTrait;
    use PageLegacyTrait;
    use PageRoutableTrait;
    use PageTranslateTrait;

    /** @var string Language code, eg: 'en' */
    protected $language;

    /** @var string File format, eg. 'md' */
    protected $format;

    /** @var bool */
    private $_initialized = false;

    /**
     * @return array
     */
    public static function getCachedMethods(): array
    {
        return [
            'path' => true,
            'full_order' => true,
            'filterBy' => true,
        ] + parent::getCachedMethods();
    }

    public function initialize(): void
    {
        if (!$this->_initialized) {
            Grav::instance()->fireEvent('onPageProcessed', new Event(['page' => $this]));
            $this->_initialized = true;
        }
    }

    /**
     * @param string|array $query
     * @return Route
     */
    public function getRoute($query = []): Route
    {
        $route = RouteFactory::createFromString($this->route());
        if (\is_array($query)) {
            foreach ($query as $key => $value) {
                $route = $route->withQueryParam($key, $value);
            }
        } else {
            $route = $route->withAddedPath($query);
        }

        return $route;
    }

    /**
     * @inheritdoc PageInterface
     */
    public function getFormValue(string $name, $default = null, string $separator = null)
    {
        $test = new \stdClass();

        $value = $this->pageContentValue($name, $test);
        if ($value !== $test) {
            return $value;
        }

        switch ($name) {
            case 'name':
                // TODO: this should not be template!
                return $this->getProperty('template');
            case 'route':
                $filesystem = Filesystem::getInstance(false);
                $key = $filesystem->dirname($this->hasKey() ? '/' . $this->getKey() : '/');
                return $key !== '/' ? $key : null;
            case 'full_route':
                return $this->hasKey() ? '/' . $this->getKey() : '';
            case 'full_order':
                return $this->full_order();
            case 'lang':
                return $this->getLanguage() ?? '';
            case 'translations':
                return $this->getLanguages();
        }

        return parent::getFormValue($name, $default, $separator);
    }

    /**
     * {@inheritdoc}
     * @see FlexObjectInterface::getCacheKey()
     */
    public function getCacheKey(): string
    {
        $cacheKey = parent::getCacheKey();
        if ($cacheKey) {
            /** @var Language $language */
            $language = Grav::instance()['language'];
            $cacheKey .= '_' . $language->getActive();
        }

        return $cacheKey;
    }

    /**
     * @param array $variables
     * @return array
     */
    protected function onBeforeSave(array $variables)
    {
        $reorder = $variables[0] ?? true;

        $meta = $this->getMetaData();
        if (($meta['copy'] ?? false) === true) {
            $this->folder = $this->getKey();
        }

        // Figure out storage path to the new route.
        $parentKey = $this->getProperty('parent_key');
        if ($parentKey !== '') {
            $parentRoute = $this->getProperty('route');

            // Root page cannot be moved.
            if ($this->root()) {
                throw new \RuntimeException(sprintf('Root page cannot be moved to %s', $parentRoute));
            }

            // Make sure page isn't being moved under itself.
            $key = $this->getKey();
            if ($key === $parentKey || strpos($parentKey, $key . '/') === 0) {
                throw new \RuntimeException(sprintf('Page /%s cannot be moved to %s', $key, $parentRoute));
            }

            /** @var PageObject|null $parent */
            $parent = $parentKey !== false ? $this->getFlexDirectory()->getObject($parentKey, 'storage_key') : null;
            if (!$parent) {
                // Page cannot be moved to non-existing location.
                throw new \RuntimeException(sprintf('Page /%s cannot be moved to non-existing path %s', $key, $parentRoute));
            }

            // TODO: make sure that the page doesn't exist yet if moved/copied.
        }

        // Reorder siblings.
        if ($reorder === true && !$this->root()) {
            $reorder = $this->_reorder;
        }

        $siblings = is_array($reorder) ? $this->reorderSiblings($reorder) : [];

        $data = $this->prepareStorage();
        unset($data['header']);

        foreach ($siblings as $sibling) {
            $data = $sibling->prepareStorage();
            unset($data['header']);
        }

        return ['reorder' => $reorder, 'siblings' => $siblings];
    }

    /**
     * @param array $variables
     * @return array
     */
    protected function onSave(array $variables): array
    {
        /** @var PageCollection $siblings */
        $siblings = $variables['siblings'];
        foreach ($siblings as $sibling) {
            $sibling->save(false);
        }

        return $variables;
    }

    /**
     * @param array $variables
     * @return array
     */
    protected function onAfterSave(array $variables): void
    {
    }

    /**
     * @param array|bool $reorder
     * @return FlexObject|\Grav\Framework\Flex\Interfaces\FlexObjectInterface
     */
    public function save($reorder = true)
    {
        $variables = $this->onBeforeSave(func_get_args());

        /** @var static $instance */
        $instance = parent::save();
        $variables = $this->onSave($variables);

        $this->onAfterSave($variables);

        return $instance;
    }

    /**
     * Prepare move page to new location. Moves also everything that's under the current page.
     *
     * You need to call $this->save() in order to perform the move.
     *
     * @param PageInterface $parent New parent page.
     *
     * @return $this
     */
    public function move(PageInterface $parent)
    {
        if (!$parent instanceof FlexObjectInterface) {
            throw new \RuntimeException('Failed: Parent is not Flex Object');
        }

        $this->_reorder = [];
        $this->setProperty('parent_key', $parent->getStorageKey());

        return $this;
    }

    /**
     * @param array $ordering
     * @return PageCollection
     */
    protected function reorderSiblings(array $ordering)
    {
        $parent = $this->parent();
        if (!$parent) {
            throw new \RuntimeException('Cannot reorder page which has no parent');
        }

        /** @var PageCollection|null $siblings */
        $siblings = $parent->children();

        /** @var PageCollection|null $siblings */
        $siblings = $siblings->getCollection()->withOrdered()->orderBy(['order' => 'ASC']);

        $storageKey = $this->getStorageKey();
        $filesystem = Filesystem::getInstance(false);
        $oldParentKey = ltrim($filesystem->dirname("/$storageKey"), '/');
        $newParentKey = $this->getProperty('parent_key');
        $isMoved =  $oldParentKey !== $newParentKey;
        $order = !$isMoved ? $this->order() : false;

        if ($storageKey !== null) {
            if ($order !== false) {
                // Add current page back to the list if it's ordered.
                $siblings->set($storageKey, $this);
            } else {
                // Remove old copy of the current page from the siblings list.
                $siblings->remove($storageKey);
            }
        }

        foreach ($siblings as $sibling) {
            $basename = basename($sibling->getKey());
            if (!in_array($basename, $ordering, true)) {
                $ordering[] = $basename;
            }
        }

        $ordering = array_flip(array_values($ordering));
        $count = count($ordering);
        foreach ($siblings as $sibling) {
            $newOrder = $ordering[basename($sibling->getKey())] ?? null;
            $newOrder = null !== $newOrder ? $newOrder + 1 : (int)$sibling->order() + $count;
            $sibling->order($newOrder);
        }
        /** @var PageCollection $siblings */
        $siblings = $siblings->orderBy(['order' => 'ASC']);
        $siblings->removeElement($this);

        // If menu item was moved, just make it to be the last in order.
        if ($isMoved && $order !== false) {
            $parentKey = $this->getProperty('parent_key');
            $newParent = $this->getFlexDirectory()->getObject($parentKey, 'storage_key');
            $newSiblings = $newParent->children()->getCollection()->withOrdered();
            $order = 0;
            foreach ($newSiblings as $sibling) {
                $order = max($order, (int)$sibling->order());
            }
            $this->order($order + 1);
        }

        return $siblings;
    }

    /**
     * @return string
     */
    public function full_order(): string
    {
        $route = $this->path() . '/' . $this->folder();

        return preg_replace(PageIndex::ORDER_LIST_REGEX, '\\1', $route) ?? $route;
    }

    /**
     * @param string $name
     * @return Blueprint
     */
    protected function doGetBlueprint(string $name = ''): Blueprint
    {
        try {
            // Make sure that pages has been initialized.
            Pages::getTypes();

            // TODO: We need to move raw blueprint logic to Grav itself to remove admin dependency here.
            if ($name === 'raw') {
                // Admin RAW mode.
                if ($this->isAdminSite()) {
                    /** @var Admin $admin */
                    $admin = Grav::instance()['admin'];

                    $template = $this->isModule() ? 'modular_raw' : ($this->root() ? 'root_raw' : 'raw');

                    return $admin->blueprints("admin/pages/{$template}");
                }
            }

            $template = $this->getProperty('template') . ($name ? '.' . $name : '');

            $blueprint = $this->getFlexDirectory()->getBlueprint($template, 'blueprints://pages');
        } catch (\RuntimeException $e) {
            $template = 'default' . ($name ? '.' . $name : '');

            $blueprint = $this->getFlexDirectory()->getBlueprint($template, 'blueprints://pages');
        }

        return $blueprint;
    }

    /**
     * @param array $options
     * @return array
     */
    public function getLevelListing(array $options): array
    {
        $index = $this->getFlexDirectory()->getIndex();

        return method_exists($index, 'getLevelListing') ? $index->getLevelListing($options) : [];
    }

    /**
     * Filter page (true/false) by given filters.
     *
     * - search: string
     * - extension: string
     * - module: bool
     * - visible: bool
     * - routable: bool
     * - published: bool
     * - page: bool
     * - translated: bool
     *
     * @param array $filters
     * @param bool $recursive
     * @return bool
     */
    public function filterBy(array $filters, bool $recursive = false): bool
    {
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'search':
                    $matches = $this->search((string)$value) > 0.0;
                    break;
                case 'page_type':
                    $types = $value ? explode(',', $value) : [];
                    $matches = in_array($this->template(), $types, true);
                    break;
                case 'extension':
                    $matches = Utils::contains((string)$value, $this->extension());
                    break;
                case 'routable':
                    $matches = $this->isRoutable() === (bool)$value;
                    break;
                case 'published':
                    $matches = $this->isPublished() === (bool)$value;
                    break;
                case 'visible':
                    $matches = $this->isVisible() === (bool)$value;
                    break;
                case 'module':
                    $matches = $this->isModule() === (bool)$value;
                    break;
                case 'page':
                    $matches = $this->isPage() === (bool)$value;
                    break;
                case 'folder':
                    $matches = $this->isPage() === !$value;
                    break;
                case 'translated':
                    $matches = $this->hasTranslation() === (bool)$value;
                    break;
                default:
                    $matches = true;
                    break;
            }

            // If current filter does not match, we still may have match as a parent.
            if ($matches === false) {
                return $recursive && $this->children()->getIndex()->filterBy($filters, true)->count() > 0;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     * @see FlexObjectInterface::exists()
     */
    public function exists(): bool
    {
        return $this->root ?: parent::exists();
    }

    /**
     * @return array
     */
    public function __debugInfo(): array
    {
        $list = parent::__debugInfo();

        return $list + [
            '_content_meta:private' => $this->getContentMeta(),
            '_content:private' => $this->getRawContent()
        ];
    }

    /**
     * @param array $elements
     * @param bool $extended
     */
    protected function filterElements(array &$elements, bool $extended = false): void
    {
        // Change parent page if needed.
        if (array_key_exists('route', $elements) && isset($elements['folder'], $elements['name'])) {
            $elements['template'] = $elements['name'];

            // Figure out storage path to the new route.
            $parentKey = trim($elements['route'] ?? '', '/');
            if ($parentKey !== '') {
                /** @var PageObject|null $parent */
                $parent = $this->getFlexDirectory()->getObject($parentKey);
                $parentKey = $parent ? $parent->getStorageKey() : $parentKey;
            }

            $elements['parent_key'] = $parentKey;
        }

        // Deal with ordering=bool and order=page1,page2,page3.
        if ($this->root()) {
            // Root page doesn't have ordering.
            unset($elements['ordering'], $elements['order']);
        } elseif (array_key_exists('ordering', $elements) && array_key_exists('order', $elements)) {
            // Store ordering.
            $this->_reorder = !empty($elements['order']) ? explode(',', $elements['order']) : [];

            $order = false;
            if ((bool)($elements['ordering'] ?? false)) {
                $order = 999999;
            }

            $this->order();
            $elements['order'] = $order;
        }

        parent::filterElements($elements, true);
    }

    /**
     * @return array
     */
    public function prepareStorage(): array
    {
        $meta = $this->getMetaData();
        $oldLang = $meta['lang'] ?? '';
        $newLang = $this->getProperty('lang', '');

        // Always clone the page to the new language.
        if ($oldLang !== $newLang) {
            $meta['clone'] = true;
        }

        // Make sure that certain elements are always sent to the storage layer.
        $elements = [
            '__META' => $meta,
            'storage_key' => $this->getStorageKey(),
            'parent_key' => $this->getProperty('parent_key'),
            'order' => $this->getProperty('order'),
            'folder' => preg_replace('|^\d+\.|', '', $this->getProperty('folder')),
            'template' => preg_replace('|modular/|', '', $this->getProperty('template')),
            'lang' => $newLang
        ] + parent::prepareStorage();

        return $elements;
    }
}

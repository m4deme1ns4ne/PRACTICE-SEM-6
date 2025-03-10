<?php

declare(strict_types=1);

/**
 * @package    Grav\Common\Flex
 *
 * @copyright  Copyright (C) 2015 - 2020 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\Flex\Types\Pages;

use Grav\Common\Debugger;
use Grav\Common\File\CompiledJsonFile;
use Grav\Common\Flex\Traits\FlexGravTrait;
use Grav\Common\Flex\Traits\FlexIndexTrait;
use Grav\Common\Grav;
use Grav\Common\Page\Header;
use Grav\Common\Page\Interfaces\PageCollectionInterface;
use Grav\Common\Page\Interfaces\PageInterface;
use Grav\Common\Utils;
use Grav\Framework\Flex\FlexDirectory;
use Grav\Framework\Flex\Interfaces\FlexCollectionInterface;
use Grav\Framework\Flex\Interfaces\FlexStorageInterface;
use Grav\Framework\Flex\Pages\FlexPageIndex;

/**
 * Class GravPageObject
 * @package Grav\Plugin\FlexObjects\Types\GravPages
 *
 * @method PageIndex withModules(bool $bool = true)
 * @method PageIndex withPages(bool $bool = true)
 * @method PageIndex withTranslation(bool $bool = true, string $languageCode = null, bool $fallback = null)
 */
class PageIndex extends FlexPageIndex implements PageCollectionInterface
{
    use FlexGravTrait;
    use FlexIndexTrait;

    public const VERSION = parent::VERSION . '.5';
    public const ORDER_LIST_REGEX = '/(\/\d+)\.[^\/]+/u';
    public const PAGE_ROUTE_REGEX = '/\/\d+\./u';

    /** @var PageObject|array */
    protected $_root;
    /** @var array|null */
    protected $_params;

    /**
     * @param array $entries
     * @param FlexDirectory|null $directory
     */
    public function __construct(array $entries = [], FlexDirectory $directory = null)
    {
        // Remove root if it's taken.
        if (isset($entries[''])) {
            $this->_root = $entries[''];
            unset($entries['']);
        }

        parent::__construct($entries, $directory);
    }

    /**
     * @param FlexStorageInterface $storage
     * @return array
     */
    public static function loadEntriesFromStorage(FlexStorageInterface $storage): array
    {
        // Load saved index.
        $index = static::loadIndex($storage);

        $version = $index['version'] ?? 0;
        $timestamp = $index['timestamp'] ?? 0;
        $force = static::VERSION !== $version;
        if (!$force && $timestamp && $timestamp > time() - 2) {
            return $index['index'];
        }

        // Load up to date index.
        $entries = parent::loadEntriesFromStorage($storage);

        return static::updateIndexFile($storage, $index['index'], $entries, ['include_missing' => true, 'force_update' => $force]);
    }

    /**
     * @param string $key
     * @return PageObject|null
     */
    public function get($key)
    {
        if (mb_strpos($key, '|') !== false) {
            [$key, $params] = explode('|', $key, 2);
        }

        $element = parent::get($key);
        if (isset($params)) {
            $element = $element->getTranslation(ltrim($params, '.'));
        }

        return $element;
    }

    /**
     * @return PageObject
     */
    public function getRoot()
    {
        $root = $this->_root;
        if (is_array($root)) {
            $directory = $this->getFlexDirectory();
            $storage = $directory->getStorage();

            $defaults = [
                'header' => [
                    'routable' => false,
                    'permissions' => [
                        'inherit' => false
                    ]
                ]
            ];

            $row = $storage->readRows(['' => null])[''] ?? null;
            if (null !== $row) {
                if (isset($row['__ERROR'])) {
                    /** @var Debugger $debugger */
                    $debugger = Grav::instance()['debugger'];
                    $message = sprintf('Flex Pages: root page is broken in storage: %s', $row['__ERROR']);

                    $debugger->addException(new \RuntimeException($message));
                    $debugger->addMessage($message, 'error');

                    $row = ['__META' => $root];
                }

            } else {
                $row = ['__META' => $root];
            }

            $row = array_merge_recursive($defaults, $row);

            /** @var PageObject $root */
            $root = $this->getFlexDirectory()->createObject($row, '/', false);
            $root->name('root.md');
            $root->root(true);

            $this->_root = $root;
        }

        return $root;
    }

    /**
     * Get the collection params
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->_params ?? [];
    }

    /**
     * Set parameters to the Collection
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->_params = $this->_params ? array_merge($this->_params, $params) : $params;

        return $this;
    }

    /**
     * Get the collection params
     *
     * @return array
     */
    public function params(): array
    {
        return $this->getParams();
    }

    /**
     * Filter pages by given filters.
     *
     * - search: string
     * - page_type: string|string[]
     * - modular: bool
     * - visible: bool
     * - routable: bool
     * - published: bool
     * - page: bool
     * - translated: bool
     *
     * @param array $filters
     * @param bool $recursive
     * @return FlexCollectionInterface
     */
    public function filterBy(array $filters, bool $recursive = false)
    {
        if (!$filters) {
            return $this;
        }

        if ($recursive) {
            return $this->__call('filterBy', [$filters, true]);
        }

        $list = [];
        $index = $this;
        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'search':
                    $index = $index->search((string)$value);
                    break;
                case 'page_type':
                    if (!is_array($value)) {
                        $value = is_string($value) && $value !== '' ? explode(',', $value) : [];
                    }
                    $index = $index->ofOneOfTheseTypes($value);
                    break;
                case 'routable':
                    $index = $index->withRoutable((bool)$value);
                    break;
                case 'published':
                    $index = $index->withPublished((bool)$value);
                    break;
                case 'visible':
                    $index = $index->withVisible((bool)$value);
                    break;
                case 'module':
                    $index = $index->withModules((bool)$value);
                    break;
                case 'page':
                    $index = $index->withPages((bool)$value);
                    break;
                case 'folder':
                    $index = $index->withPages(!$value);
                    break;
                case 'translated':
                    $index = $index->withTranslation((bool)$value);
                    break;
                default:
                    $list[$key] = $value;
            }
        }

        return $list ? $index->filterByParent($list) : $index;
    }

    /**
     * @param array $filters
     * @return FlexCollectionInterface
     */
    protected function filterByParent(array $filters)
    {
        return parent::filterBy($filters);
    }

    /**
     * @param array $options
     * @return array
     */
    public function getLevelListing(array $options): array
    {
        // Undocumented B/C
        $order = $options['order'] ?? 'asc';
        if ($order === SORT_ASC) {
            $options['order'] = 'asc';
        } elseif ($order === SORT_DESC) {
            $options['order'] = 'desc';
        }

        $options += [
            'field' => null,
            'route' => null,
            'leaf_route' => null,
            'sortby' => null,
            'order' => 'asc',
            'lang' => null,
            'filters' => [],
        ];

        $options['filters'] += [
            'type' => ['root', 'dir'],
        ];

        return $this->getLevelListingRecurse($options);
    }

    /**
     * @param array $entries
     * @param string|null $keyField
     * @return $this|FlexPageIndex
     */
    protected function createFrom(array $entries, string $keyField = null)
    {
        /** @var static $index */
        $index = parent::createFrom($entries, $keyField);
        $index->_root = $this->getRoot();

        return $index;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function getLevelListingRecurse(array $options): array
    {
        $filters = $options['filters'] ?? [];
        $field = $options['field'];
        $route = $options['route'];
        $leaf_route = $options['leaf_route'];
        $sortby = $options['sortby'];
        $order = $options['order'];
        $language = $options['lang'];

        $status = 'error';
        $msg = null;
        $response = [];
        $children = null;
        $sub_route = null;
        $extra = null;

        // Handle leaf_route
        $leaf = null;
        if ($leaf_route && $route !== $leaf_route) {
            $nodes = explode('/', $leaf_route);
            $sub_route =  '/' . implode('/', array_slice($nodes, 1, $options['level']++));
            $options['route'] = $sub_route;

            [$status,,$leaf,$extra] = $this->getLevelListingRecurse($options);
        }

        // Handle no route, assume page tree root
        if (!$route) {
            $page = $this->getRoot();
        } else {
            $page = $this->get(trim($route, '/'));
        }
        $path = $page ? $page->path() : null;

        if ($field) {
            // Get forced filters from the field.
            $blueprint = $page ? $page->getBlueprint() : $this->getFlexDirectory()->getBlueprint();
            $settings = $blueprint->schema()->getProperty($field);
            $filters = array_merge([], $filters, $settings['filters'] ?? []);
        }

        // Clean up filter.
        $filter_type = (array)($filters['type'] ?? []);
        unset($filters['type']);
        $filters = array_filter($filters, static function($val) { return $val !== null && $val !== ''; });

        if ($page) {
            if ($page->root() && (!$filter_type || in_array('root', $filter_type, true))) {
                if ($field) {
                    $response[] = [
                        'name' => '<root>',
                        'value' => '/',
                        'item-key' => '',
                        'filename' => '.',
                        'extension' => '',
                        'type' => 'root',
                        'modified' => $page->modified(),
                        'size' => 0,
                        'symlink' => false,
                        'has-children' => false
                    ];
                } else {
                    $response[] = [
                        'item-key' => '-root-',
                        'icon' => 'root',
                        'title' => 'Root', // FIXME
                        'route' => [
                            'display' => '&lt;root&gt;', // FIXME
                            'raw' => '_root',
                        ],
                        'modified' => $page->modified(),
                        'extras' => [
                            'template' => $page->template(),
                            //'lang' => null,
                            //'translated' => null,
                            'langs' => [],
                            'published' => false,
                            'visible' => false,
                            'routable' => false,
                            'tags' => ['root', 'non-routable'],
                            'actions' => ['edit'], // FIXME
                        ]
                    ];
                }
            }

            $status = 'success';
            $msg = 'PLUGIN_ADMIN.PAGE_ROUTE_FOUND';

            /** @var PageIndex $children */
            $children = $page->children()->getIndex();
            $selectedChildren = $children->filterBy($filters, true);

            /** @var Header $header */
            $header = $page->header();

            if ($header->get('admin.children_display_order') === 'collection' && ($orderby = $header->get('content.order.by'))) {
                // Use custom sorting by page header.
                $sortby = $orderby;
                $order = $header->get('content.order.dir', $order);
                $custom = $header->get('content.order.custom');
            }

            if ($sortby) {
                // Sort children.
                $selectedChildren = $selectedChildren->order($sortby, $order, $custom ?? null);
            }

            /** @var PageObject $child */
            foreach ($selectedChildren as $child) {
                $selected = $child->path() === $extra;
                $includeChildren = \is_array($leaf) && !empty($leaf) && $selected;
                if ($field) {
                    $child_count = count($child->children());
                    $payload = [
                        'name' => $child->menu(),
                        'value' => $child->rawRoute(),
                        'item-key' => basename($child->rawRoute() ?? ''),
                        'filename' => $child->folder(),
                        'extension' => $child->extension(),
                        'type' => 'dir',
                        'modified' => $child->modified(),
                        'size' => $child_count,
                        'symlink' => false,
                        'has-children' => $child_count > 0
                    ];
                } else {
                    // TODO: all these features are independent from each other, we cannot just have one icon/color to catch all.
                    // TODO: maybe icon by home/modular/page/folder (or even from blueprints) and color by visibility etc..
                    if ($child->home()) {
                        $icon = 'home';
                    } elseif ($child->isModule()) {
                        $icon = 'modular';
                    } elseif ($child->visible()) {
                        $icon = 'visible';
                    } elseif ($child->isPage()) {
                        $icon = 'page';
                    } else {
                        // TODO: add support
                        $icon = 'folder';
                    }
                    $tags = [
                        $child->published() ? 'published' : 'non-published',
                        $child->visible() ? 'visible' : 'non-visible',
                        $child->routable() ? 'routable' : 'non-routable'
                    ];
                    $lang = $child->findTranslation($language) ?? 'n/a';
                    /** @var PageObject $child */
                    $child = $child->getTranslation($language) ?? $child;
                    $extras = [
                        'template' => $child->template(),
                        'lang' => $lang ?: null,
                        'translated' => $lang ? $child->hasTranslation($language, false) : null,
                        'langs' => $child->getAllLanguages(true) ?: null,
                        'published' => $child->published(),
                        'published_date' => $this->jsDate($child->publishDate()),
                        'unpublished_date' => $this->jsDate($child->unpublishDate()),
                        'visible' => $child->visible(),
                        'routable' => $child->routable(),
                        'tags' => $tags,
                        'actions' => null,
                    ];
                    $extras = array_filter($extras, static function ($v) {
                        return $v !== null;
                    });
                    $tmp = $child->children()->getIndex();
                    $child_count = $tmp->count();
                    $count = $filters ? $tmp->filterBy($filters, true)->count() : null;
                    $payload = [
                        'item-key' => basename($child->rawRoute() ?? $child->getKey()),
                        'icon' => $icon,
                        'title' => $child->menu(),
                        'route' => [
                            'display' => $child->getRoute()->toString(false) ?: '/',
                            'raw' => $child->rawRoute(),
                        ],
                        'modified' => $this->jsDate($child->modified()),
                        'child_count' => $child_count ?: null,
                        'count' => $count ?? null,
                        'filters_hit' => $filters ? ($child->filterBy($filters, false) ?: null) : null,
                        'extras' => $extras
                    ];
                    $payload = array_filter($payload, static function ($v) {
                        return $v !== null;
                    });
                }

                // Add children if any
                if ($includeChildren) {
                    $payload['children'] = array_values($leaf);
                }

                $response[] = $payload;
            }
        } else {
            $msg = 'PLUGIN_ADMIN.PAGE_ROUTE_NOT_FOUND';
        }

        if ($field) {
            $temp_array = [];
            foreach ($response as $index => $item) {
                $temp_array[$item['type']][$index] = $item;
            }

            $sorted = Utils::sortArrayByArray($temp_array, $filter_type);
            $response = Utils::arrayFlatten($sorted);
        }

        return [$status, $msg ?? 'PLUGIN_ADMIN.NO_ROUTE_PROVIDED', $response, $path];
    }

    /**
     * @param FlexStorageInterface $storage
     * @return CompiledJsonFile|\Grav\Common\File\CompiledYamlFile|null
     */
    protected static function getIndexFile(FlexStorageInterface $storage)
    {
        if (!method_exists($storage, 'isIndexed') || !$storage->isIndexed()) {
            return null;
        }

        // Load saved index file.
        $grav = Grav::instance();
        $locator = $grav['locator'];

        $filename = $locator->findResource('user-data://flex/indexes/pages.json', true, true);

        return CompiledJsonFile::instance($filename);
    }

    /**
     * @param int|null $timestamp
     * @return string|null
     */
    private function jsDate(int $timestamp = null): ?string
    {
        if (!$timestamp) {
            return null;
        }

        $config = Grav::instance()['config'];
        $dateFormat = $config->get('system.pages.dateformat.long');

        return date($dateFormat, $timestamp) ?: null;
    }

    /**
     * Add a single page to a collection
     *
     * @param PageInterface $page
     *
     * @return PageCollection
     */
    public function addPage(PageInterface $page)
    {
        return $this->getCollection()->addPage($page);
    }

    /**
     *
     * Create a copy of this collection
     *
     * @return static
     */
    public function copy()
    {
        return clone $this;
    }

    /**
     *
     * Merge another collection with the current collection
     *
     * @param PageCollectionInterface $collection
     * @return $this
     */
    public function merge(PageCollectionInterface $collection)
    {
        return $this->getCollection()->merge($collection);
    }


    /**
     * Intersect another collection with the current collection
     *
     * @param PageCollectionInterface $collection
     * @return $this
     */
    public function intersect(PageCollectionInterface $collection)
    {
        return $this->getCollection()->intersect($collection);
    }

    /**
     * Split collection into array of smaller collections.
     *
     * @param int $size
     * @return PageCollectionInterface[]
     */
    public function batch($size)
    {
        return $this->getCollection()->batch($size);
    }

    /**
     * Remove item from the list.
     *
     * @param PageInterface|string|null $key
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function remove($key = null)
    {
        return $this->getCollection()->remove($key);
    }

    /**
     * Reorder collection.
     *
     * @param string $by
     * @param string $dir
     * @param array  $manual
     * @param string $sort_flags
     *
     * @return PageCollectionInterface
     */
    public function order($by, $dir = 'asc', $manual = null, $sort_flags = null)
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('order', [$by, $dir, $manual, $sort_flags]);

        return $collection;
    }

    /**
     * Check to see if this item is the first in the collection.
     *
     * @param  string $path
     *
     * @return bool True if item is first.
     */
    public function isFirst($path): bool
    {
        /** @var bool $result */
        $result = $this->__call('isFirst', [$path]);

        return $result;

    }

    /**
     * Check to see if this item is the last in the collection.
     *
     * @param  string $path
     *
     * @return bool True if item is last.
     */
    public function isLast($path): bool
    {
        /** @var bool $result */
        $result = $this->__call('isLast', [$path]);

        return $result;
    }

    /**
     * Gets the previous sibling based on current position.
     *
     * @param  string $path
     *
     * @return PageInterface|null  The previous item.
     */
    public function prevSibling($path)
    {
        /** @var PageInterface|null $result */
        $result = $this->__call('prevSibling', [$path]);

        return $result;
    }

    /**
     * Gets the next sibling based on current position.
     *
     * @param  string $path
     *
     * @return PageInterface|null The next item.
     */
    public function nextSibling($path)
    {
        /** @var PageInterface|null $result */
        $result = $this->__call('nextSibling', [$path]);

        return $result;
    }

    /**
     * Returns the adjacent sibling based on a direction.
     *
     * @param  string  $path
     * @param  int $direction either -1 or +1
     *
     * @return PageInterface|PageCollectionInterface|false    The sibling item.
     */
    public function adjacentSibling($path, $direction = 1)
    {
        /** @var PageInterface|PageCollectionInterface|false $result */
        $result = $this->__call('adjacentSibling', [$path, $direction]);

        return $result;
    }

    /**
     * Returns the item in the current position.
     *
     * @param  string $path the path the item
     *
     * @return int|null The index of the current page, null if not found.
     */
    public function currentPosition($path): ?int
    {
        /** @var int|null $result */
        $result = $this->__call('currentPosition', [$path]);

        return $result;
    }

    /**
     * Returns the items between a set of date ranges of either the page date field (default) or
     * an arbitrary datetime page field where end date is optional
     * Dates can be passed in as text that strtotime() can process
     * http://php.net/manual/en/function.strtotime.php
     *
     * @param string $startDate
     * @param bool $endDate
     * @param string|null $field
     *
     * @return PageCollectionInterface
     * @throws \Exception
     */
    public function dateRange($startDate, $endDate = false, $field = null)
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('dateRange', [$startDate, $endDate, $field]);

        return $collection;
    }

    /**
     * Creates new collection with only visible pages
     *
     * @return PageCollectionInterface The collection with only visible pages
     */
    public function visible()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('visible', []);

        return $collection;
    }

    /**
     * Creates new collection with only non-visible pages
     *
     * @return PageCollectionInterface The collection with only non-visible pages
     */
    public function nonVisible()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('nonVisible', []);

        return $collection;
    }

    /**
     * Creates new collection with only modular pages
     *
     * @return PageCollectionInterface The collection with only modular pages
     */
    public function modular()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('modular', []);

        return $collection;
    }

    /**
     * Creates new collection with only non-modular pages
     *
     * @return PageCollectionInterface The collection with only non-modular pages
     */
    public function nonModular()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('nonModular', []);

        return $collection;

    }

    /**
     * Creates new collection with only published pages
     *
     * @return PageCollectionInterface The collection with only published pages
     */
    public function published()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('published', []);

        return $collection;
    }

    /**
     * Creates new collection with only non-published pages
     *
     * @return PageCollectionInterface The collection with only non-published pages
     */
    public function nonPublished()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('nonPublished', []);

        return $collection;
    }

    /**
     * Creates new collection with only routable pages
     *
     * @return PageCollectionInterface The collection with only routable pages
     */
    public function routable()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('routable', []);

        return $collection;
    }

    /**
     * Creates new collection with only non-routable pages
     *
     * @return PageCollectionInterface The collection with only non-routable pages
     */
    public function nonRoutable()
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('nonRoutable', []);

        return $collection;
    }

    /**
     * Creates new collection with only pages of the specified type
     *
     * @param string $type
     *
     * @return PageCollectionInterface The collection
     */
    public function ofType($type)
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('ofType', []);

        return $collection;
    }

    /**
     * Creates new collection with only pages of one of the specified types
     *
     * @param string[] $types
     *
     * @return PageCollectionInterface The collection
     */
    public function ofOneOfTheseTypes($types)
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('ofOneOfTheseTypes', []);

        return $collection;
    }

    /**
     * Creates new collection with only pages of one of the specified access levels
     *
     * @param array $accessLevels
     *
     * @return PageCollectionInterface The collection
     */
    public function ofOneOfTheseAccessLevels($accessLevels)
    {
        /** @var PageCollectionInterface $collection */
        $collection = $this->__call('ofOneOfTheseAccessLevels', []);

        return $collection;
    }

    /**
     * Converts collection into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getCollection()->toArray();
    }

    /**
     * Get the extended version of this Collection with each page keyed by route
     *
     * @return array
     * @throws \Exception
     */
    public function toExtendedArray()
    {
        return $this->getCollection()->toExtendedArray();
    }

}

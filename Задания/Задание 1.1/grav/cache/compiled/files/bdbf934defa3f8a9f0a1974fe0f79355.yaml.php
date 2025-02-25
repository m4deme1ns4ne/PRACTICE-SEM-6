<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/plugins/admin/blueprints.yaml',
    'modified' => 1588284109,
    'data' => [
        'name' => 'Admin Panel',
        'slug' => 'admin',
        'type' => 'plugin',
        'version' => '1.10.0-rc.10',
        'testing' => true,
        'description' => 'Adds an advanced administration panel to manage your site',
        'icon' => 'empire',
        'author' => [
            'name' => 'Team Grav',
            'email' => 'devs@getgrav.org',
            'url' => 'http://getgrav.org'
        ],
        'homepage' => 'https://github.com/getgrav/grav-plugin-admin',
        'keywords' => 'admin, plugin, manager, panel',
        'bugs' => 'https://github.com/getgrav/grav-plugin-admin/issues',
        'docs' => 'https://github.com/getgrav/grav-plugin-admin/blob/develop/README.md',
        'license' => 'MIT',
        'dependencies' => [
            0 => [
                'name' => 'grav',
                'version' => '>=1.7.0-rc.10'
            ],
            1 => [
                'name' => 'form',
                'version' => '>=4.0.7'
            ],
            2 => [
                'name' => 'login',
                'version' => '>=3.2.0'
            ],
            3 => [
                'name' => 'email',
                'version' => '>=3.0.8'
            ],
            4 => [
                'name' => 'flex-objects',
                'version' => '>=1.0.0-rc.10'
            ]
        ],
        'form' => [
            'validation' => 'loose',
            'fields' => [
                'admin_tabs' => [
                    'type' => 'tabs',
                    'fields' => [
                        'config_tab' => [
                            'type' => 'tab',
                            'title' => 'Configuration',
                            'fields' => [
                                'Basics' => [
                                    'type' => 'section',
                                    'title' => 'Basics',
                                    'underline' => false
                                ],
                                'enabled' => [
                                    'type' => 'hidden',
                                    'label' => 'PLUGIN_ADMIN.PLUGIN_STATUS',
                                    'highlight' => 1,
                                    'default' => 0,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ]
                                ],
                                'cache_enabled' => [
                                    'type' => 'toggle',
                                    'label' => 'PLUGIN_ADMIN.ADMIN_CACHING',
                                    'help' => 'PLUGIN_ADMIN.ADMIN_CACHING_HELP',
                                    'highlight' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.YES',
                                        0 => 'PLUGIN_ADMIN.NO'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ]
                                ],
                                'twofa_enabled' => [
                                    'type' => 'toggle',
                                    'label' => 'PLUGIN_LOGIN.2FA_TITLE',
                                    'help' => 'PLUGIN_LOGIN.2FA_ENABLED_HELP',
                                    'default' => 1,
                                    'highlight' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.YES',
                                        0 => 'PLUGIN_ADMIN.NO'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ]
                                ],
                                'route' => [
                                    'type' => 'text',
                                    'label' => 'Administrator path',
                                    'size' => 'medium',
                                    'placeholder' => 'Default route for administrator (relative to base)',
                                    'help' => 'If you want to change the URL for the administrator, you can provide a path here'
                                ],
                                'logo_text' => [
                                    'type' => 'text',
                                    'label' => 'Logo text',
                                    'size' => 'medium',
                                    'placeholder' => 'Grav',
                                    'help' => 'Text to display in place of the default Grav logo'
                                ],
                                'content_padding' => [
                                    'type' => 'toggle',
                                    'label' => 'PLUGIN_ADMIN.CONTENT_PADDING',
                                    'help' => 'PLUGIN_ADMIN.CONTENT_PADDING_HELP',
                                    'highlight' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.YES',
                                        0 => 'PLUGIN_ADMIN.NO'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ]
                                ],
                                'body_classes' => [
                                    'type' => 'text',
                                    'label' => 'Body classes',
                                    'size' => 'medium',
                                    'help' => 'Add a space separated name of custom body classes'
                                ],
                                'sidebar.activate' => [
                                    'type' => 'select',
                                    'label' => 'Sidebar Activation',
                                    'help' => 'Control how the sidebar is activated',
                                    'size' => 'small',
                                    'default' => 'tab',
                                    'options' => [
                                        'tab' => 'Tab',
                                        'hover' => 'Hover'
                                    ]
                                ],
                                'sidebar.hover_delay' => [
                                    'type' => 'text',
                                    'size' => 'x-small',
                                    'append' => 'millseconds',
                                    'label' => 'Hover delay',
                                    'default' => 500,
                                    'validate' => [
                                        'type' => 'number',
                                        'min' => 1
                                    ]
                                ],
                                'sidebar.size' => [
                                    'type' => 'select',
                                    'label' => 'Sidebar Size',
                                    'help' => 'Control the width of the sidebar',
                                    'size' => 'medium',
                                    'default' => 'auto',
                                    'options' => [
                                        'auto' => 'Automatic width',
                                        'small' => 'Small width'
                                    ]
                                ],
                                'theme' => [
                                    'type' => 'hidden',
                                    'label' => 'Theme',
                                    'default' => 'grav'
                                ],
                                'edit_mode' => [
                                    'type' => 'select',
                                    'label' => 'Edit mode',
                                    'size' => 'small',
                                    'default' => 'normal',
                                    'options' => [
                                        'normal' => 'Normal',
                                        'expert' => 'Expert'
                                    ],
                                    'help' => 'Auto will use blueprint if available, if none found, it will use "Expert" mode.'
                                ],
                                'frontend_preview_target' => [
                                    'type' => 'select',
                                    'label' => 'Preview pages target',
                                    'size' => 'medium',
                                    'default' => 'inline',
                                    'options' => [
                                        'inline' => 'Inline in Admin',
                                        '_blank' => 'New tab',
                                        '_self' => 'Current tab'
                                    ]
                                ],
                                'pages.show_parents' => [
                                    'type' => 'select',
                                    'size' => 'medium',
                                    'label' => 'Parent dropdown',
                                    'highlight' => 1,
                                    'options' => [
                                        'both' => 'Show slug and folder',
                                        'folder' => 'Show folder',
                                        'fullpath' => 'Show fullpath'
                                    ]
                                ],
                                'pages.parents_levels' => [
                                    'type' => 'text',
                                    'label' => 'Parents Levels',
                                    'size' => 'small',
                                    'help' => 'The number of levels to show in parent select list'
                                ],
                                'pages.show_modular' => [
                                    'type' => 'toggle',
                                    'label' => 'Modular parents',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Show modular pages in the parent select list'
                                ],
                                'google_fonts' => [
                                    'type' => 'toggle',
                                    'label' => 'Use Google Fonts',
                                    'highlight' => 0,
                                    'default' => 0,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Use Google custom fonts.  Disable this to use Helvetica. Useful when using Cyrillic and other languages with unsupported characters.'
                                ],
                                'show_beta_msg' => [
                                    'type' => 'hidden'
                                ],
                                'show_github_msg' => [
                                    'type' => 'toggle',
                                    'label' => 'Show GitHub Link',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Show the "Found an issue? Please report it on GitHub." message.'
                                ],
                                'pages_list_display_field' => [
                                    'type' => 'text',
                                    'size' => 'small',
                                    'label' => 'Pages List Display Field',
                                    'help' => 'Field of the page to use in the list of pages if present. Defaults/Fallback to title.'
                                ],
                                'enable_auto_updates_check' => [
                                    'type' => 'toggle',
                                    'label' => 'Automatically check for updates',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Shows an informative message, in the admin panel, when an update is available.'
                                ],
                                'session.timeout' => [
                                    'type' => 'text',
                                    'size' => 'small',
                                    'label' => 'Session Timeout',
                                    'append' => 'secs',
                                    'help' => 'Sets the session timeout in seconds',
                                    'validate' => [
                                        'type' => 'number',
                                        'min' => 1
                                    ]
                                ],
                                'warnings.delete_page' => [
                                    'type' => 'toggle',
                                    'label' => 'Warn on page delete',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Ask the user confirmation when deleting a page'
                                ],
                                'warnings.secure_delete' => [
                                    'type' => 'toggle',
                                    'label' => 'Secure Delete',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Shows the user a field to enter the word DELETE and enable the confirm delete button.'
                                ],
                                'hide_page_types' => [
                                    'type' => 'select',
                                    'size' => 'large',
                                    'label' => 'Hide page types in Admin',
                                    'classes' => 'fancy',
                                    'multiple' => true,
                                    'array' => true,
                                    'selectize' => [
                                        'create' => true
                                    ],
                                    'data-options@' => [
                                        0 => '\\Grav\\Plugin\\AdminPlugin::pagesTypes',
                                        1 => true
                                    ]
                                ],
                                'hide_modular_page_types' => [
                                    'type' => 'select',
                                    'size' => 'large',
                                    'label' => 'Hide modular page types in Admin',
                                    'classes' => 'fancy',
                                    'multiple' => true,
                                    'array' => true,
                                    'selectize' => [
                                        'create' => true
                                    ],
                                    'data-options@' => [
                                        0 => '\\Grav\\Plugin\\AdminPlugin::pagesModularTypes',
                                        1 => true
                                    ]
                                ],
                                'Dashboard' => [
                                    'type' => 'section',
                                    'title' => 'Dashboard',
                                    'underline' => true
                                ],
                                'widgets_display' => [
                                    'type' => 'widgets',
                                    'label' => 'Widget Display Status',
                                    'validate' => [
                                        'type' => 'array'
                                    ]
                                ],
                                'Notifications' => [
                                    'type' => 'section',
                                    'title' => 'Notifications',
                                    'underline' => true
                                ],
                                'notifications.feed' => [
                                    'type' => 'toggle',
                                    'label' => 'Feed Notifications',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Display feed-based notifications'
                                ],
                                'notifications.dashboard' => [
                                    'type' => 'toggle',
                                    'label' => 'Dashboard Notifications',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Display dashboard-based notifications'
                                ],
                                'notifications.plugins' => [
                                    'type' => 'toggle',
                                    'label' => 'Plugins Notifications',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Display plugins-targeted notifications'
                                ],
                                'notifications.themes' => [
                                    'type' => 'toggle',
                                    'label' => 'Themes Notifications',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Display themes-targeted notifications'
                                ]
                            ]
                        ],
                        'customization_tab' => [
                            'type' => 'tab',
                            'title' => 'Customization',
                            'fields' => [
                                'whitelabel.logos' => [
                                    'type' => 'section',
                                    'underline' => true,
                                    'title' => 'PLUGIN_ADMIN.LOGOS'
                                ],
                                'whitelabel.logo_login' => [
                                    'type' => 'file',
                                    'label' => 'PLUGIN_ADMIN.LOGIN_SCREEN_CUSTOM_LOGO_LABEL',
                                    'destination' => 'user://assets',
                                    'accept' => [
                                        0 => 'image/*'
                                    ]
                                ],
                                'whitelabel.logo_custom' => [
                                    'type' => 'file',
                                    'label' => 'PLUGIN_ADMIN.TOP_LEFT_CUSTOM_LOGO_LABEL',
                                    'destination' => 'user://assets',
                                    'accept' => [
                                        0 => 'image/*'
                                    ]
                                ],
                                'whitelabel.customization' => [
                                    'type' => 'section',
                                    'underline' => true,
                                    'title' => 'PLUGIN_ADMIN.CUSTOMIZATION'
                                ],
                                'themes-preview' => [
                                    'type' => 'themepreview',
                                    'ignore' => 'true;',
                                    'label' => 'PLUGIN_ADMIN.PRESETS',
                                    'style' => 'vertical'
                                ],
                                'colorschemes' => [
                                    'type' => 'colorscheme',
                                    'label' => 'PLUGIN_ADMIN.COLOR_SCHEME_LABEL',
                                    'style' => 'vertical',
                                    'help' => 'PLUGIN_ADMIN.COLOR_SCHEME_HELP',
                                    'fields' => [
                                        'whitelabel.color_scheme.colors.logo-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#1e333e',
                                            'help' => 'Logo bg'
                                        ],
                                        'whitelabel.color_scheme.colors.logo-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Logo link'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#253a47',
                                            'help' => 'Nav bg'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#afc7d5',
                                            'help' => 'Nav text'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#d1dee7',
                                            'help' => 'Nav link'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-selected-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#2d4d5b',
                                            'help' => 'Nav selected bg'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-selected-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Nav selected link'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-hover-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#1e333e',
                                            'help' => 'Nav hover bg'
                                        ],
                                        'whitelabel.color_scheme.colors.nav-hover-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Nav hover link'
                                        ],
                                        'whitelabel.color_scheme.colors.toolbar-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#349886',
                                            'help' => 'Toolbar bg'
                                        ],
                                        'whitelabel.color_scheme.colors.toolbar-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Toolbar text'
                                        ],
                                        'whitelabel.color_scheme.colors.page-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#314d5b',
                                            'help' => 'Page bg'
                                        ],
                                        'whitelabel.color_scheme.colors.page-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#81a5b5',
                                            'help' => 'Page text'
                                        ],
                                        'whitelabel.color_scheme.colors.page-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#aad9ed',
                                            'help' => 'Page link'
                                        ],
                                        'whitelabel.color_scheme.colors.content-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#eeeeee',
                                            'help' => 'Content bg'
                                        ],
                                        'whitelabel.color_scheme.colors.content-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#737c81',
                                            'help' => 'Content text'
                                        ],
                                        'whitelabel.color_scheme.colors.content-link' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#0082ba',
                                            'help' => 'Content link'
                                        ],
                                        'whitelabel.color_scheme.colors.content-link2' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#da4b46',
                                            'help' => 'Content link 2'
                                        ],
                                        'whitelabel.color_scheme.colors.content-header' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#314d5b',
                                            'help' => 'Content header'
                                        ],
                                        'whitelabel.color_scheme.colors.content-tabs-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#223a47',
                                            'help' => 'Content tabs bg'
                                        ],
                                        'whitelabel.color_scheme.colors.content-tabs-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#d1dee7',
                                            'help' => 'Content tabs text'
                                        ],
                                        'whitelabel.color_scheme.colors.button-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#41bea8',
                                            'help' => 'Button bg'
                                        ],
                                        'whitelabel.color_scheme.colors.button-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Button text'
                                        ],
                                        'whitelabel.color_scheme.colors.notice-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#00a6cf',
                                            'help' => 'Notice bg'
                                        ],
                                        'whitelabel.color_scheme.colors.notice-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Notice text'
                                        ],
                                        'whitelabel.color_scheme.colors.update-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#8f5aad',
                                            'help' => 'Updates bg'
                                        ],
                                        'whitelabel.color_scheme.colors.update-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Updates text'
                                        ],
                                        'whitelabel.color_scheme.colors.critical-bg' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#da4b46',
                                            'help' => 'Critical bg'
                                        ],
                                        'whitelabel.color_scheme.colors.critical-text' => [
                                            'type' => 'colorscheme.color',
                                            'default' => '#ffffff',
                                            'help' => 'Critical text'
                                        ]
                                    ]
                                ],
                                'whitelabel.color_scheme.accents.primary-accent' => [
                                    'type' => 'select',
                                    'size' => 'meidum',
                                    'classes' => 'fancy',
                                    'label' => 'PLUGIN_ADMIN.PRIMARY_ACCENT_LABEL',
                                    'help' => 'PLUGIN_ADMIN.PRIMARY_ACCENT_HELP',
                                    'options' => [
                                        'button' => 'Button colors',
                                        'content' => 'Content colors',
                                        'tabs' => 'Tabs colors',
                                        'critical' => 'Critical colors',
                                        'logo' => 'Logo colors',
                                        'nav' => 'Nav colors',
                                        'notice' => 'Notice colors',
                                        'page' => 'Page colors',
                                        'toolbar' => 'Toolbar colors',
                                        'update' => 'Update colors'
                                    ]
                                ],
                                'whitelabel.color_scheme.accents.secondary-accent' => [
                                    'type' => 'select',
                                    'size' => 'meidum',
                                    'classes' => 'fancy',
                                    'label' => 'PLUGIN_ADMIN.SECONDARY_ACCENT_LABEL',
                                    'help' => 'PLUGIN_ADMIN.SECONDARY_ACCENT_HELP',
                                    'options' => [
                                        'button' => 'Button colors',
                                        'content' => 'Content colors',
                                        'tabs' => 'Tabs colors',
                                        'critical' => 'Critical colors',
                                        'logo' => 'Logo colors',
                                        'nav' => 'Nav colors',
                                        'notice' => 'Notice colors',
                                        'page' => 'Page colors',
                                        'toolbar' => 'Toolbar colors',
                                        'update' => 'Update colors'
                                    ]
                                ],
                                'whitelabel.color_scheme.accents.tertiary-accent' => [
                                    'type' => 'select',
                                    'size' => 'meidum',
                                    'classes' => 'fancy',
                                    'label' => 'PLUGIN_ADMIN.TERTIARY_ACCENT_LABEL',
                                    'help' => 'PLUGIN_ADMIN.TERTIARY_ACCENT_HELP',
                                    'options' => [
                                        'button' => 'Button colors',
                                        'content' => 'Content colors',
                                        'tabs' => 'Tabs colors',
                                        'critical' => 'Critical colors',
                                        'logo' => 'Logo colors',
                                        'nav' => 'Nav colors',
                                        'notice' => 'Notice colors',
                                        'page' => 'Page colors',
                                        'toolbar' => 'Toolbar colors',
                                        'update' => 'Update colors'
                                    ]
                                ],
                                'whitelabel.custom_footer' => [
                                    'type' => 'textarea',
                                    'rows' => 2,
                                    'label' => 'PLUGIN_ADMIN.CUSTOM_FOOTER',
                                    'help' => 'PLUGIN_ADMIN.CUSTOM_FOOTER_HELP',
                                    'placeholder' => 'Enter HTML/Markdown to override default footer'
                                ],
                                'whitelabel.custom_css' => [
                                    'type' => 'textarea',
                                    'rows' => 10,
                                    'label' => 'PLUGIN_ADMIN.CUSTOM_CSS_LABEL',
                                    'placeholder' => 'Put your custom CSS in here...',
                                    'help' => 'PLUGIN_ADMIN.CUSTOM_CSS_HELP'
                                ]
                            ]
                        ],
                        'extras_tab' => [
                            'type' => 'tab',
                            'title' => 'Extras',
                            'fields' => [
                                'Popularity' => [
                                    'type' => 'section',
                                    'title' => 'Popularity',
                                    'underline' => true
                                ],
                                'popularity.enabled' => [
                                    'type' => 'toggle',
                                    'label' => 'Visitor tracking',
                                    'highlight' => 1,
                                    'default' => 1,
                                    'options' => [
                                        1 => 'PLUGIN_ADMIN.ENABLED',
                                        0 => 'PLUGIN_ADMIN.DISABLED'
                                    ],
                                    'validate' => [
                                        'type' => 'bool'
                                    ],
                                    'help' => 'Enable the visitors stats collecting feature'
                                ],
                                'dashboard.days_of_stats' => [
                                    'type' => 'text',
                                    'label' => 'Days of stats',
                                    'append' => 'days',
                                    'size' => 'x-small',
                                    'default' => 7,
                                    'help' => 'Keep stats for the specified number of days, then drop them',
                                    'validate' => [
                                        'type' => 'int'
                                    ]
                                ],
                                'popularity.ignore' => [
                                    'type' => 'array',
                                    'label' => 'Ignore',
                                    'size' => 'large',
                                    'help' => 'URLs to ignore',
                                    'default' => [
                                        0 => '/test*',
                                        1 => '/modular'
                                    ],
                                    'value_only' => true,
                                    'placeholder_value' => '/ignore-this-route'
                                ],
                                'popularity.history.daily' => [
                                    'type' => 'hidden',
                                    'label' => 'Daily history',
                                    'default' => 30
                                ],
                                'popularity.history.monthly' => [
                                    'type' => 'hidden',
                                    'label' => 'Monthly history',
                                    'default' => 12
                                ],
                                'popularity.history.visitors' => [
                                    'type' => 'hidden',
                                    'label' => 'Visitors history',
                                    'default' => 20
                                ],
                                'MediaResize' => [
                                    'type' => 'section',
                                    'title' => 'Page Media Image Resizer',
                                    'underline' => true
                                ],
                                'MediaResizeNote' => [
                                    'type' => 'spacer',
                                    'text' => 'PLUGIN_ADMIN.PAGEMEDIA_RESIZER',
                                    'markdown' => true
                                ],
                                'pagemedia.resize_width' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resize Width',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'Resize wide images down to the set value'
                                ],
                                'pagemedia.resize_height' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resize Height',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'Resize tall images down to the set value'
                                ],
                                'pagemedia.res_min_width' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resolution Min Width',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'The minimum width allowed for an image to be added'
                                ],
                                'pagemedia.res_min_height' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resolution Min Height',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'The minimum height allowed for an image to be added'
                                ],
                                'pagemedia.res_max_width' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resolution Max Width',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'The maximum width allowed for an image to be added'
                                ],
                                'pagemedia.res_max_height' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => 'pixels',
                                    'label' => 'Resolution Max Height',
                                    'default' => 0,
                                    'validate' => [
                                        'type' => 'number'
                                    ],
                                    'help' => 'The maximum height allowed for an image to be added'
                                ],
                                'pagemedia.resize_quality' => [
                                    'type' => 'number',
                                    'size' => 'x-small',
                                    'append' => '0...1',
                                    'label' => 'Resize Quality',
                                    'default' => 0.8,
                                    'validate' => [
                                        'type' => 'number',
                                        'step' => 0.01
                                    ],
                                    'help' => 'The quality to use when resizing an image. Between 0 and 1 value.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

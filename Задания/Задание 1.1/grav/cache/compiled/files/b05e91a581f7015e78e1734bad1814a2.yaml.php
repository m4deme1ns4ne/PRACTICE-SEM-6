<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/system/config/system.yaml',
    'modified' => 1588284109,
    'data' => [
        'absolute_urls' => false,
        'timezone' => '',
        'default_locale' => NULL,
        'param_sep' => ':',
        'wrapped_site' => false,
        'reverse_proxy_setup' => false,
        'force_ssl' => false,
        'force_lowercase_urls' => true,
        'custom_base_url' => '',
        'username_regex' => '^[a-z0-9_-]{3,16}$',
        'pwd_regex' => '(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}',
        'intl_enabled' => true,
        'languages' => [
            'supported' => [
                
            ],
            'default_lang' => NULL,
            'include_default_lang' => true,
            'include_default_lang_file_extension' => true,
            'pages_fallback_only' => false,
            'translations' => true,
            'translations_fallback' => true,
            'session_store_active' => false,
            'http_accept_language' => false,
            'override_locale' => false
        ],
        'home' => [
            'alias' => '/home',
            'hide_in_urls' => false
        ],
        'pages' => [
            'type' => 'regular',
            'theme' => 'quark',
            'order' => [
                'by' => 'default',
                'dir' => 'asc'
            ],
            'list' => [
                'count' => 20
            ],
            'dateformat' => [
                'default' => NULL,
                'short' => 'jS M Y',
                'long' => 'F jS \\a\\t g:ia'
            ],
            'publish_dates' => true,
            'process' => [
                'markdown' => true,
                'twig' => false
            ],
            'twig_first' => false,
            'never_cache_twig' => false,
            'events' => [
                'page' => true,
                'twig' => true
            ],
            'markdown' => [
                'extra' => false,
                'auto_line_breaks' => false,
                'auto_url_links' => false,
                'escape_markup' => false,
                'special_chars' => [
                    '>' => 'gt',
                    '<' => 'lt'
                ]
            ],
            'types' => [
                0 => 'html',
                1 => 'htm',
                2 => 'xml',
                3 => 'txt',
                4 => 'json',
                5 => 'rss',
                6 => 'atom'
            ],
            'append_url_extension' => '',
            'expires' => 604800,
            'cache_control' => NULL,
            'last_modified' => false,
            'etag' => false,
            'vary_accept_encoding' => false,
            'redirect_default_route' => false,
            'redirect_default_code' => 302,
            'redirect_trailing_slash' => true,
            'ignore_files' => [
                0 => '.DS_Store'
            ],
            'ignore_folders' => [
                0 => '.git',
                1 => '.idea'
            ],
            'ignore_hidden' => true,
            'hide_empty_folders' => false,
            'url_taxonomy_filters' => true,
            'frontmatter' => [
                'process_twig' => false,
                'ignore_fields' => [
                    0 => 'form',
                    1 => 'forms'
                ]
            ]
        ],
        'cache' => [
            'enabled' => true,
            'check' => [
                'method' => 'file'
            ],
            'driver' => 'auto',
            'prefix' => 'g',
            'purge_at' => '0 4 * * *',
            'clear_at' => '0 3 * * *',
            'clear_job_type' => 'standard',
            'clear_images_by_default' => true,
            'cli_compatibility' => false,
            'lifetime' => 604800,
            'gzip' => false,
            'allow_webserver_gzip' => false,
            'redis' => [
                'socket' => false
            ]
        ],
        'twig' => [
            'cache' => true,
            'debug' => true,
            'auto_reload' => true,
            'autoescape' => false,
            'undefined_functions' => true,
            'undefined_filters' => true,
            'umask_fix' => false
        ],
        'assets' => [
            'css_pipeline' => false,
            'css_pipeline_include_externals' => true,
            'css_pipeline_before_excludes' => true,
            'css_minify' => true,
            'css_minify_windows' => false,
            'css_rewrite' => true,
            'js_pipeline' => false,
            'js_pipeline_include_externals' => true,
            'js_pipeline_before_excludes' => true,
            'js_minify' => true,
            'enable_asset_timestamp' => false,
            'collections' => [
                'jquery' => 'system://assets/jquery/jquery-2.x.min.js'
            ]
        ],
        'errors' => [
            'display' => 0,
            'log' => true
        ],
        'log' => [
            'handler' => 'file',
            'syslog' => [
                'facility' => 'local6'
            ]
        ],
        'debugger' => [
            'enabled' => false,
            'provider' => 'clockwork',
            'censored' => false,
            'shutdown' => [
                'close_connection' => true
            ]
        ],
        'images' => [
            'default_image_quality' => 85,
            'cache_all' => false,
            'cache_perms' => '0755',
            'debug' => false,
            'auto_fix_orientation' => false,
            'seofriendly' => false
        ],
        'media' => [
            'enable_media_timestamp' => false,
            'unsupported_inline_types' => [
                
            ],
            'allowed_fallback_types' => [
                
            ],
            'auto_metadata_exif' => false
        ],
        'session' => [
            'enabled' => true,
            'initialize' => true,
            'timeout' => 1800,
            'name' => 'grav-site',
            'uniqueness' => 'path',
            'secure' => false,
            'httponly' => true,
            'split' => true,
            'path' => NULL
        ],
        'gpm' => [
            'releases' => 'testing',
            'proxy_url' => NULL,
            'method' => 'auto',
            'verify_peer' => true,
            'official_gpm_only' => true
        ],
        'accounts' => [
            'type' => 'regular',
            'storage' => 'file'
        ],
        'flex' => [
            'cache' => [
                'index' => [
                    'enabled' => true,
                    'lifetime' => 60
                ],
                'object' => [
                    'enabled' => true,
                    'lifetime' => 600
                ],
                'render' => [
                    'enabled' => true,
                    'lifetime' => 600
                ]
            ]
        ],
        'strict_mode' => [
            'yaml_compat' => true,
            'twig_compat' => true,
            'blueprint_compat' => true
        ]
    ]
];

<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/plugins/error/blueprints.yaml',
    'modified' => 1588284109,
    'data' => [
        'name' => 'Error',
        'version' => '1.6.2',
        'description' => 'Displays the error page.',
        'icon' => 'warning',
        'author' => [
            'name' => 'Team Grav',
            'email' => 'devs@getgrav.org',
            'url' => 'http://getgrav.org'
        ],
        'homepage' => 'https://github.com/getgrav/grav-plugin-error',
        'keywords' => 'error, plugin, required',
        'bugs' => 'https://github.com/getgrav/grav-plugin-error/issues',
        'license' => 'MIT',
        'form' => [
            'validation' => 'strict',
            'fields' => [
                'enabled' => [
                    'type' => 'toggle',
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
                'routes.404' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_ERROR.ROUTE_404',
                    'default' => '/error'
                ]
            ]
        ]
    ]
];

<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/user/plugins/email/blueprints.yaml',
    'modified' => 1588284109,
    'data' => [
        'name' => 'Email',
        'slug' => 'email',
        'type' => 'plugin',
        'version' => '3.0.8',
        'testing' => false,
        'description' => 'Enables the emailing system for Grav',
        'icon' => 'envelope',
        'author' => [
            'name' => 'Team Grav',
            'email' => 'devs@getgrav.org',
            'url' => 'http://getgrav.org'
        ],
        'keywords' => 'plugin, email, sender',
        'homepage' => 'https://github.com/getgrav/grav-plugin-email',
        'bugs' => 'https://github.com/getgrav/grav-plugin-email/issues',
        'license' => 'MIT',
        'dependencies' => [
            0 => [
                'name' => 'grav',
                'version' => '>=1.6.0'
            ],
            1 => [
                'name' => 'form',
                'version' => '>=3.0.3'
            ]
        ],
        'form' => [
            'validation' => 'loose',
            'fields' => [
                'enabled' => [
                    'type' => 'hidden',
                    'label' => 'PLUGIN_ADMIN.PLUGIN_STATUS',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'mailer.engine' => [
                    'type' => 'select',
                    'label' => 'PLUGIN_EMAIL.MAIL_ENGINE',
                    'size' => 'medium',
                    'options' => [
                        'none' => 'PLUGIN_ADMIN.DISABLED',
                        'smtp' => 'SMTP',
                        'sendmail' => 'Sendmail'
                    ]
                ],
                'content_type' => [
                    'type' => 'select',
                    'label' => 'PLUGIN_EMAIL.CONTENT_TYPE',
                    'size' => 'medium',
                    'default' => 'text/html',
                    'options' => [
                        'text/plain' => 'PLUGIN_EMAIL.CONTENT_TYPE_PLAIN_TEXT',
                        'text/html' => 'HTML'
                    ]
                ],
                'charset' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.CHARSET',
                    'placeholder' => 'PLUGIN_EMAIL.CHARSET_PLACEHOLDER'
                ],
                'email_Defaults' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_EMAIL.EMAIL_DEFAULTS',
                    'underline' => true
                ],
                'from' => [
                    'type' => 'email',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_FORM',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_FORM_PLACEHOLDER',
                    'validate' => [
                        'required' => true,
                        'type' => 'email'
                    ]
                ],
                'from_name' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_FROM_NAME',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_FROM_NAME_PLACEHOLDER'
                ],
                'to' => [
                    'type' => 'email',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_TO',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_TO_PLACEHOLDER',
                    'multiple' => true,
                    'validate' => [
                        'required' => true,
                        'type' => 'email'
                    ]
                ],
                'to_name' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_TO_NAME',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_TO_NAME_PLACEHOLDER'
                ],
                'cc' => [
                    'type' => 'email',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_CC',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_CC_PLACEHOLDER',
                    'multiple' => true,
                    'validate' => [
                        'type' => 'email'
                    ]
                ],
                'cc_name' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_CC_NAME',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_CC_NAME_PLACEHOLDER'
                ],
                'bcc' => [
                    'type' => 'email',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_BCC',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_BCC_PLACEHOLDER',
                    'multiple' => true,
                    'validate' => [
                        'type' => 'email'
                    ]
                ],
                'reply_to' => [
                    'type' => 'email',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_REPLY_TO',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_REPLY_TO_PLACEHOLDER',
                    'multiple' => true,
                    'validate' => [
                        'type' => 'email'
                    ]
                ],
                'reply_to_name' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_REPLY_TO_NAME',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_REPLY_TO_NAME_PLACEHOLDER'
                ],
                'body' => [
                    'type' => 'textarea',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.EMAIL_BODY',
                    'placeholder' => 'PLUGIN_EMAIL.EMAIL_BODY_PLACEHOLDER'
                ],
                'smtp_config' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_EMAIL.SMTP_CONFIGURATION',
                    'underline' => true
                ],
                'mailer.smtp.server' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.SMTP_SERVER',
                    'placeholder' => 'PLUGIN_EMAIL.SMTP_SERVER_PLACEHOLDER'
                ],
                'mailer.smtp.port' => [
                    'type' => 'text',
                    'size' => 'small',
                    'label' => 'PLUGIN_EMAIL.SMTP_PORT',
                    'placeholder' => 'PLUGIN_EMAIL.SMTP_PORT_PLACEHOLDER',
                    'validate' => [
                        'type' => 'number',
                        'min' => 1,
                        'max' => 65535
                    ]
                ],
                'mailer.smtp.encryption' => [
                    'type' => 'select',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.SMTP_ENCRYPTION',
                    'options' => [
                        'none' => 'PLUGIN_EMAIL.SMTP_ENCRYPTION_NONE',
                        'ssl' => 'SSL',
                        'tls' => 'TLS'
                    ]
                ],
                'mailer.smtp.user' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'autocomplete' => 'nope',
                    'label' => 'PLUGIN_EMAIL.SMTP_LOGIN_NAME'
                ],
                'mailer.smtp.password' => [
                    'type' => 'password',
                    'size' => 'medium',
                    'autocomplete' => 'nope',
                    'label' => 'PLUGIN_EMAIL.SMTP_PASSWORD'
                ],
                'sendmail_config' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_EMAIL.SENDMAIL_CONFIGURATION',
                    'underline' => true
                ],
                'mailer.sendmail.bin' => [
                    'type' => 'text',
                    'size' => 'medium',
                    'label' => 'PLUGIN_EMAIL.PATH_TO_SENDMAIL',
                    'placeholder' => '/usr/sbin/sendmail'
                ],
                'queue_section' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_EMAIL.QUEUE_TITLE',
                    'text' => 'PLUGIN_EMAIL.QUEUE_DESC',
                    'markdown' => true,
                    'underline' => true
                ],
                'queue.enabled' => [
                    'type' => 'toggle',
                    'label' => 'PLUGIN_EMAIL.QUEUE_ENABLED',
                    'highlight' => 0,
                    'default' => 0,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'queue.flush_frequency' => [
                    'type' => 'cron',
                    'label' => 'PLUGIN_EMAIL.QUEUE_FLUSH_FREQUENCY',
                    'size' => 'medium',
                    'help' => 'PLUGIN_EMAIL.QUEUE_FLUSH_FREQUENCY_HELP',
                    'default' => '* * * * *',
                    'placeholder' => '* * * * *'
                ],
                'queue.flush_msg_limit' => [
                    'type' => 'number',
                    'label' => 'PLUGIN_EMAIL.QUEUE_FLUSH_MSG_LIMIT',
                    'size' => 'x-small',
                    'append' => 'PLUGIN_EMAIL.QUEUE_FLUSH_MSG_LIMIT_APPEND'
                ],
                'queue.flush_time_limit' => [
                    'type' => 'number',
                    'label' => 'PLUGIN_EMAIL.QUEUE_FLUSH_TIME_LIMIT',
                    'size' => 'x-small',
                    'append' => 'PLUGIN_EMAIL.QUEUE_FLUSH_TIME_LIMIT_APPEND'
                ],
                'advanced_section' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_EMAIL.ADVANCED',
                    'underline' => true
                ],
                'debug' => [
                    'type' => 'toggle',
                    'label' => 'PLUGIN_EMAIL.DEBUG',
                    'highlight' => 1,
                    'default' => 0,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ]
            ]
        ]
    ]
];

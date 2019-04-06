<?php

declare(strict_types=1);

use corbomite\flashdata\actions\CreateMigrationsAction;

return [
    'flash' => [
        'description' => 'Corbomite Flash Data Commands',
        'commands' => [
            'create-migrations' => [
                'description' => 'Adds migrations to create flash data tables',
                'class' => CreateMigrationsAction::class,
            ],
        ],
    ],
];

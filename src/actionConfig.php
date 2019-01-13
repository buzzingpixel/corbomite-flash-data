<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

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

<?php

declare(strict_types=1);

namespace corbomite\tests;

use corbomite\flashdata\actions\CreateMigrationsAction;
use PHPUnit\Framework\TestCase;

class ActionConfigTest extends TestCase
{
    public function test() : void
    {
        $config = require TESTING_APP_PATH . '/src/actionConfig.php';

        self::assertEquals(
            [
                'flash' => [
                    'description' => 'Corbomite Flash Data Commands',
                    'commands' => [
                        'create-migrations' => [
                            'description' => 'Adds migrations to create flash data tables',
                            'class' => CreateMigrationsAction::class,
                        ],
                    ],
                ],
            ],
            $config
        );
    }
}

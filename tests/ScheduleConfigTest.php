<?php

declare(strict_types=1);

namespace corbomite\tests;

use corbomite\flashdata\services\FlashDataGarbageCollectionService;
use PHPUnit\Framework\TestCase;

class ScheduleConfigTest extends TestCase
{
    public function test() : void
    {
        $config = require TESTING_APP_PATH . '/src/scheduleConfig.php';

        self::assertEquals(
            [
                [
                    'class' => FlashDataGarbageCollectionService::class,
                    'runEvery' => 'Always',
                ],
            ],
            $config
        );
    }
}

<?php

declare(strict_types=1);

use corbomite\flashdata\services\FlashDataGarbageCollectionService;

return [
    [
        'class' => FlashDataGarbageCollectionService::class,
        'runEvery' => 'Always',
    ],
];

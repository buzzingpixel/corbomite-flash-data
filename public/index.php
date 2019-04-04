<?php

declare(strict_types=1);

use corbomite\di\Di;
use corbomite\flashdata\FlashDataApi;

putenv('ENCRYPTION_KEY=1234567890qwertyuiopasdfghjklzxc');
putenv('DB_HOST=db');
putenv('DB_DATABASE=site');
putenv('DB_USER=site');
putenv('DB_PASSWORD=secret');

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/devMode.php';

/** @noinspection PhpUnhandledExceptionInspection */
$flashDataApi = Di::diContainer()->get(FlashDataApi::class);

// $model = $flashDataApi->makeFlashDataModel(['name' => 'test_flash_data_key']);
// $model->dataItem('myItem', 'myVal');
// $flashDataApi->setFlashData($model);
// die;

var_dump($flashDataApi->getFlashData()->getStoreItem('test_flash_data_key'));

<?php

declare(strict_types=1);

use corbomite\di\Di;
use corbomite\flashdata\FlashDataApi;

/** @noinspection PhpUnhandledExceptionInspection */
$flashDataApi = Di::get(FlashDataApi::class);

// $model = $flashDataApi->makeFlashDataModel([
//     'name' => 'test_flash_data_key',
// ]);
// $model->dataItem('myItem', 'myVal');
// $flashDataApi->setFlashData($model);
// die;

var_dump($flashDataApi->getFlashData()->getStoreItem('test_flash_data_key'));

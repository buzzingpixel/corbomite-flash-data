# Corbomite Flash Data

<p><a href="https://travis-ci.org/buzzingpixel/corbomite-flash-data"><img src="https://travis-ci.org/buzzingpixel/corbomite-flash-data.svg?branch=master"></a></p>

Part of BuzzingPixel's Corbomite project.

Provides a means of flashing data to the next user's HTTP request.

## Notes

### Flash Data Storage

Corbomite Flash Data uses cookies only to store the reference to the UUID key of the user's flash data table. This means that, since data is not being stored in a cookie, you can flash almost any data you want (within reason).

### Garbage Collection

Corbomite Flash Data provides a schedule config for [Corbomite Schedule](https://github.com/buzzingpixel/corbomite-schedule) to run the Corbomite garbage collector. Flash data is meant to be short lived, therefore this garbage collector removes flash data that is more than 2 minutes old. You'll want to be sure that you've installed and set up the scheduler and that it's running on your application in production.

## Installation

Corbomite Flash Data needs to add a database table in order to function. In order to do this, it needs to create some migrations which then need to be run. Run the `create-migrations` command, which will place migration files in your Corbomite project.

```bash
php app flash/create-migrations
```

After running that command, you'll need to run the migrations:

```bash
php app migrate/up
```

## Usage

Setting flash data

```php
<?php
$model = $flashDataApi->makeFlashDataModel(['name' => 'test_flash_data_key']);
$model->dataItem('myItem', 'myVal');
$flashDataApi->setFlashData($model);
```

Getting flash data

```php
<?php
var_dump($flashDataApi->getFlashData()->getStoreItem('test_flash_data_key'));
```

Note that the flash data will be deleted immediately upon retrieval unless an argument of false is provided to `getFlashData`.

```php
<?php
var_dump($flashDataApi->getFlashData(false)->getStoreItem('test_flash_data_key'));
```

## License

Copyright 2019 BuzzingPixel, LLC

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at [http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0).

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

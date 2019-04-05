<?php

declare(strict_types=1);

namespace corbomite\tests\models;

use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\models\FlashDataStoreModel;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FlashDataStoreModelTest extends TestCase
{
    public function testStore() : void
    {
        $model = new FlashDataStoreModel();

        self::assertNull($model->store());

        $exception = null;

        try {
            $model->store(['test' => 'asdf']);
        } catch (InvalidArgumentException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(InvalidArgumentException::class, $exception);

        self::assertEquals('$store must be an array of FlashDataModelInterface', $exception->getMessage());

        $modelOne = new FlashDataModel();

        $modelTwo = new FlashDataModel();

        $model->store([
            'modelOne' => $modelOne,
            'modelTwo' => $modelTwo,
        ]);

        self::assertSame($modelOne, $model->store()['modelOne']);

        self::assertSame($modelTwo, $model->store()['modelTwo']);
    }

    public function testSetAndGetStoreItem() : void
    {
        $model = new FlashDataStoreModel();

        self::assertNull($model->getStoreItem('baz'));

        $modelOne = new FlashDataModel(['name' => 'foo']);

        $modelTwo = new FlashDataModel(['name' => 'bar']);

        $model->setStoreItem($modelOne);

        $model->setStoreItem($modelTwo);

        self::assertEquals(
            [
                'foo' => $modelOne,
                'bar' => $modelTwo,
            ],
            $model->store()
        );

        self::assertSame($modelOne, $model->getStoreItem('foo'));

        self::assertSame($modelTwo, $model->getStoreItem('bar'));

        self::assertNull($model->getStoreItem('baz'));
    }
}

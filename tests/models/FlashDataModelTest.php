<?php

declare(strict_types=1);

namespace corbomite\tests\models;

use corbomite\flashdata\models\FlashDataModel;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Throwable;

class FlashDataModelTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testGuid() : void
    {
        self::assertInstanceOf(Uuid::class, (new UuidFactory())->fromString((new FlashDataModel())->guid()));

        $testGuid = (new UuidFactory())->uuid1()->toString();

        $model = new FlashDataModel(['guid' => $testGuid]);

        self::assertEquals(
            $testGuid,
            $model->guid()
        );

        $model = new FlashDataModel();

        $testGuid2 = (new UuidFactory())->uuid1()->toString();

        self::assertEquals(
            $testGuid2,
            $model->guid($testGuid2)
        );

        self::assertEquals(
            $testGuid2,
            $model->guid()
        );
    }

    public function testName() : void
    {
        self::assertEquals(
            '',
            (new FlashDataModel())->name()
        );

        $model = new FlashDataModel(['name' => 'fooBar']);

        self::assertEquals(
            'fooBar',
            $model->name()
        );

        $model = new FlashDataModel();

        self::assertEquals(
            'baz',
            $model->name('baz')
        );

        self::assertEquals(
            'baz',
            $model->name()
        );
    }

    public function testData() : void
    {
        self::assertEquals(
            [],
            (new FlashDataModel())->data()
        );

        $model = new FlashDataModel([
            'data' => [
                'foo' => 'bar',
                'baz' => 'foo',
            ],
        ]);

        self::assertEquals(
            [
                'foo' => 'bar',
                'baz' => 'foo',
            ],
            $model->data()
        );

        $model = new FlashDataModel();

        self::assertEquals(
            ['test' => 'asdf'],
            $model->data(['test' => 'asdf'])
        );

        self::assertEquals(
            ['test' => 'asdf'],
            $model->data()
        );
    }

    public function testDataItem() : void
    {
        self::assertNull(
            (new FlashDataModel())->dataItem('foo')
        );

        self::assertEquals(
            'fooBarBaz',
            (new FlashDataModel())->dataItem('foo', 'fooBarBaz')
        );

        $model = new FlashDataModel([
            'data' => [
                'foo' => 'bar',
                'baz' => 'bacon',
            ],
        ]);

        self::assertEquals(
            'bacon',
            $model->dataItem('baz')
        );
    }

    /**
     * @throws Throwable
     */
    public function testAddedAt() : void
    {
        self::assertNull(
            (new FlashDataModel())->addedAt()
        );

        $dateTime = new DateTimeImmutable();

        $model = new FlashDataModel(['addedAt' => $dateTime]);

        self::assertEquals(
            $dateTime->format('Y-m-d H:i:s'),
            $model->addedAt()->format('Y-m-d H:i:s')
        );

        $model = new FlashDataModel();

        $newDateTime = new DateTimeImmutable('20 years ago');

        self::assertEquals(
            $newDateTime->format('Y-m-d H:i:s'),
            $model->addedAt($newDateTime)->format('Y-m-d H:i:s')
        );

        self::assertSame(
            $newDateTime,
            $model->addedAt()
        );
    }
}

<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\services;

use DateTime;
use DateTimeZone;
use corbomite\db\PDO;
use Ramsey\Uuid\UuidFactoryInterface;
use buzzingpixel\cookieapi\CookieApi;
use corbomite\db\Factory as OrmFactory;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\exceptions\InvalidFlashDataModelException;

class SetFlashDataService
{
    private $pdo;
    private $cookieApi;
    private $ormFactory;
    private $uuidFactory;
    private $flashDataStoreModel;

    public function __construct(
        PDO $pdo,
        CookieApi $cookieApi,
        OrmFactory $ormFactory,
        UuidFactoryInterface $uuidFactory,
        FlashDataStoreModelInterface $flashDataStoreModel
    ) {
        $this->pdo = $pdo;
        $this->cookieApi = $cookieApi;
        $this->ormFactory = $ormFactory;
        $this->uuidFactory = $uuidFactory;
        $this->flashDataStoreModel = $flashDataStoreModel;
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function __invoke(FlashDataModelInterface $model): void
    {
        $this->set($model);
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function set(FlashDataModelInterface $model): void
    {
        if (! $keyCookie = $this->cookieApi->retrieveCookie('flash_data_key')) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $keyCookie = $this->cookieApi->makeCookie(
                'flash_data_key',
                $this->uuidFactory->uuid4()->toString()
            );

            $this->cookieApi->saveCookie($keyCookie);
        }

        if (! $model->name()) {
            throw new InvalidFlashDataModelException();
        }

        $sql = 'DELETE FROM flash_data WHERE guid = :guid AND name = :name';
        $q = $this->pdo->prepare($sql);
        $q->bindParam(':guid', $keyCookie->value());
        $q->bindParam(':name', $model->name());
        $q->execute();

        /** @noinspection PhpUnhandledExceptionInspection */
        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $orm = $this->ormFactory->makeOrm();

        $record = $orm->newRecord(FlashDatum::class);
        $record->guid = $keyCookie->value();
        $record->name = $model->name();
        $record->data = json_encode($model->data());
        $record->added_at = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();

        $orm->persist($record);

        $this->flashDataStoreModel->setStoreItem($model);
    }
}

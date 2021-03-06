<?php

declare(strict_types=1);

namespace corbomite\flashdata\services;

use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory as OrmFactory;
use corbomite\db\PDO;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\exceptions\InvalidFlashDataModelException;
use corbomite\flashdata\interfaces\FlashDataModelInterface;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use DateTime;
use DateTimeZone;
use Ramsey\Uuid\UuidFactoryInterface;
use function json_encode;

class SetFlashDataService
{
    /** @var PDO */
    private $pdo;
    /** @var CookieApiInterface */
    private $cookieApi;
    /** @var OrmFactory */
    private $ormFactory;
    /** @var UuidFactoryInterface */
    private $uuidFactory;
    /** @var FlashDataStoreModelInterface */
    private $flashDataStoreModel;

    public function __construct(
        PDO $pdo,
        CookieApiInterface $cookieApi,
        OrmFactory $ormFactory,
        UuidFactoryInterface $uuidFactory,
        FlashDataStoreModelInterface $flashDataStoreModel
    ) {
        $this->pdo                 = $pdo;
        $this->cookieApi           = $cookieApi;
        $this->ormFactory          = $ormFactory;
        $this->uuidFactory         = $uuidFactory;
        $this->flashDataStoreModel = $flashDataStoreModel;
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function __invoke(FlashDataModelInterface $model) : void
    {
        $this->set($model);
    }

    /**
     * @throws InvalidFlashDataModelException
     */
    public function set(FlashDataModelInterface $model) : void
    {
        $keyCookie = $this->cookieApi->retrieveCookie('flash_data_key');

        if (! $keyCookie || ! $keyCookie->value()) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $keyCookie = $this->cookieApi->makeCookie(
                'flash_data_key',
                $this->uuidFactory->uuid1()->toString()
            );

            $this->cookieApi->saveCookie($keyCookie);
        }

        if (! $model->name()) {
            throw new InvalidFlashDataModelException();
        }

        $key  = $this->uuidFactory->fromString($keyCookie->value())->getBytes();
        $name = $model->name();

        $sql = 'DELETE FROM flash_data WHERE guid = :guid AND name = :name';
        $q   = $this->pdo->prepare($sql);
        $q->bindParam(':guid', $key);
        $q->bindParam(':name', $name);
        $q->execute();

        /** @noinspection PhpUnhandledExceptionInspection */
        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $orm = $this->ormFactory->makeOrm();

        $record                     = $orm->newRecord(FlashDatum::class);
        $record->guid               = $key;
        $record->name               = $name;
        $record->data               = json_encode($model->data());
        $record->added_at           = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();

        $orm->persist($record);

        $this->flashDataStoreModel->setStoreItem($model);
    }
}

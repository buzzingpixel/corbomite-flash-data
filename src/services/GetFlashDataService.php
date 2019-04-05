<?php

declare(strict_types=1);

namespace corbomite\flashdata\services;

use buzzingpixel\cookieapi\interfaces\CookieApiInterface;
use corbomite\db\Factory as OrmFactory;
use corbomite\db\PDO;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;
use corbomite\flashdata\models\FlashDataModel;
use DateTimeImmutable;
use DateTimeZone;
use function is_array;
use function json_decode;

class GetFlashDataService
{
    /** @var PDO */
    private $pdo;
    /** @var CookieApiInterface */
    private $cookieApi;
    /** @var OrmFactory */
    private $ormFactory;
    /** @var FlashDataStoreModelInterface */
    private $flashDataStoreModel;

    public function __construct(
        PDO $pdo,
        CookieApiInterface $cookieApi,
        OrmFactory $ormFactory,
        FlashDataStoreModelInterface $flashDataStoreModel
    ) {
        $this->pdo                 = $pdo;
        $this->cookieApi           = $cookieApi;
        $this->ormFactory          = $ormFactory;
        $this->flashDataStoreModel = $flashDataStoreModel;
    }

    public function __invoke(bool $clearData = true) : FlashDataStoreModelInterface
    {
        return $this->get($clearData);
    }

    public function get(bool $clearData = true) : FlashDataStoreModelInterface
    {
        $keyCookie = $this->cookieApi->retrieveCookie('flash_data_key');

        $store = $this->flashDataStoreModel->store();

        if ($store === null) {
            $this->flashDataStoreModel->store([]);
        }

        if ($store !== null || ! $keyCookie) {
            return $this->flashDataStoreModel;
        }

        $key = $keyCookie->value();

        $records = $this->ormFactory->makeOrm()->select(FlashDatum::class)
            ->where('guid =', $key)
            ->fetchRecords();

        foreach ($records as $record) {
            $data = json_decode($record->data, true);

            /** @noinspection PhpUnhandledExceptionInspection */
            $addedAt = new DateTimeImmutable(
                $record->added_at,
                new DateTimeZone($record->added_at_time_zone)
            );

            $this->flashDataStoreModel->setStoreItem(new FlashDataModel([
                'guid' => $record->guid,
                'name' => $record->name,
                'data' => is_array($data) ? $data : [],
                'addedAt' =>$addedAt,
            ]));
        }

        if ($clearData) {
            $sql = 'DELETE FROM flash_data WHERE guid = :guid';
            $q   = $this->pdo->prepare($sql);
            $q->bindParam(':guid', $key);
            $q->execute();
        }

        return $this->flashDataStoreModel;
    }
}

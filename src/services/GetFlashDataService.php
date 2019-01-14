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
use buzzingpixel\cookieapi\CookieApi;
use corbomite\db\Factory as OrmFactory;
use corbomite\flashdata\models\FlashDataModel;
use corbomite\flashdata\data\FlashDatum\FlashDatum;
use corbomite\flashdata\interfaces\FlashDataStoreModelInterface;

class GetFlashDataService
{
    private $pdo;
    private $cookieApi;
    private $ormFactory;
    private $flashDataStoreModel;

    public function __construct(
        PDO $pdo,
        CookieApi $cookieApi,
        OrmFactory $ormFactory,
        FlashDataStoreModelInterface $flashDataStoreModel
    ) {
        $this->pdo = $pdo;
        $this->cookieApi = $cookieApi;
        $this->ormFactory = $ormFactory;
        $this->flashDataStoreModel = $flashDataStoreModel;
    }

    public function __invoke(bool $clearData = true): FlashDataStoreModelInterface
    {
        return $this->get($clearData);
    }

    public function get(bool $clearData = true): FlashDataStoreModelInterface
    {
        $keyCookie = $this->cookieApi->retrieveCookie('flash_data_key');

        $store = $this->flashDataStoreModel->store();

        if ($store === null) {
            $this->flashDataStoreModel->store([]);
        }

        if ($store !== null || ! $keyCookie) {
            return $this->flashDataStoreModel;
        }

        $records = $this->ormFactory->makeOrm()->select(FlashDatum::class)
            ->where('guid =', $keyCookie->value())
            ->fetchRecords();

        foreach($records as $record) {
            $data = json_decode($record->data, true);

            /** @noinspection PhpUnhandledExceptionInspection */
            $addedAt = new DateTime(
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
            $q = $this->pdo->prepare($sql);
            $q->bindParam(':guid', $keyCookie->value());
            $q->execute();
        }

        return $this->flashDataStoreModel;
    }
}

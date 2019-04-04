<?php

declare(strict_types=1);

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Table\Row;

/**
 * @property mixed $id int(10,0) NOT NULL
 * @property mixed $guid varchar(255) NOT NULL
 * @property mixed $name text(65535)
 * @property mixed $data text(65535)
 * @property mixed $added_at datetime
 * @property mixed $added_at_time_zone varchar(255)
 */
class FlashDatumRow extends Row
{
    protected $cols = [
        'id' => null,
        'guid' => null,
        'name' => 'NULL',
        'data' => 'NULL',
        'added_at' => 'NULL',
        'added_at_time_zone' => 'NULL',
    ];
}

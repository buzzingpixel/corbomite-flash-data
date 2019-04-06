<?php

declare(strict_types=1);

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Table\Row;

/**
 * @property mixed $guid binary(16) NOT NULL
 * @property mixed $name text(65535)
 * @property mixed $data text(65535)
 * @property mixed $added_at datetime NOT NULL
 * @property mixed $added_at_time_zone varchar(255) NOT NULL
 */
class FlashDatumRow extends Row
{
    protected $cols = [
        'guid' => null,
        'name' => 'NULL',
        'data' => 'NULL',
        'added_at' => null,
        'added_at_time_zone' => null,
    ];
}

<?php
/**
 * This file was generated by Atlas. Changes will be overwritten.
 */
declare(strict_types=1);

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Table\Table;

/**
 * @method FlashDatumRow|null fetchRow($primaryVal)
 * @method FlashDatumRow[] fetchRows(array $primaryVals)
 * @method FlashDatumTableSelect select(array $whereEquals = [])
 * @method FlashDatumRow newRow(array $cols = [])
 * @method FlashDatumRow newSelectedRow(array $cols)
 */
class FlashDatumTable extends Table
{
    const DRIVER = 'mysql';

    const NAME = 'flash_data';

    const COLUMNS = [
        'guid' => [
            'name' => 'guid',
            'type' => 'binary',
            'size' => 16,
            'scale' => null,
            'notnull' => true,
            'default' => null,
            'autoinc' => false,
            'primary' => true,
            'options' => null,
        ],
        'name' => [
            'name' => 'name',
            'type' => 'text',
            'size' => 65535,
            'scale' => null,
            'notnull' => false,
            'default' => 'NULL',
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
        'data' => [
            'name' => 'data',
            'type' => 'text',
            'size' => 65535,
            'scale' => null,
            'notnull' => false,
            'default' => 'NULL',
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
        'added_at' => [
            'name' => 'added_at',
            'type' => 'datetime',
            'size' => null,
            'scale' => null,
            'notnull' => true,
            'default' => null,
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
        'added_at_time_zone' => [
            'name' => 'added_at_time_zone',
            'type' => 'varchar',
            'size' => 255,
            'scale' => null,
            'notnull' => true,
            'default' => null,
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
    ];

    const COLUMN_NAMES = [
        'guid',
        'name',
        'data',
        'added_at',
        'added_at_time_zone',
    ];

    const COLUMN_DEFAULTS = [
        'guid' => null,
        'name' => 'NULL',
        'data' => 'NULL',
        'added_at' => null,
        'added_at_time_zone' => null,
    ];

    const PRIMARY_KEY = [
        'guid',
    ];

    const AUTOINC_COLUMN = null;

    public const AUTOINC_SEQUENCE = null;
}

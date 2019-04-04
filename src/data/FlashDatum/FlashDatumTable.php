<?php

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
    public const DRIVER = 'mysql';

    public const NAME = 'flash_data';

    public const COLUMNS = [
        'id' => [
            'name' => 'id',
            'type' => 'int',
            'size' => 10,
            'scale' => 0,
            'notnull' => true,
            'default' => null,
            'autoinc' => true,
            'primary' => true,
            'options' => null,
        ],
        'guid' => [
            'name' => 'guid',
            'type' => 'varchar',
            'size' => 255,
            'scale' => null,
            'notnull' => true,
            'default' => null,
            'autoinc' => false,
            'primary' => false,
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
            'notnull' => false,
            'default' => 'NULL',
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
        'added_at_time_zone' => [
            'name' => 'added_at_time_zone',
            'type' => 'varchar',
            'size' => 255,
            'scale' => null,
            'notnull' => false,
            'default' => 'NULL',
            'autoinc' => false,
            'primary' => false,
            'options' => null,
        ],
    ];

    public const COLUMN_NAMES = [
        'id',
        'guid',
        'name',
        'data',
        'added_at',
        'added_at_time_zone',
    ];

    public const COLUMN_DEFAULTS = [
        'id' => null,
        'guid' => null,
        'name' => 'NULL',
        'data' => 'NULL',
        'added_at' => 'NULL',
        'added_at_time_zone' => 'NULL',
    ];

    public const PRIMARY_KEY = ['id'];

    public const AUTOINC_COLUMN = 'id';

    public const AUTOINC_SEQUENCE = null;
}

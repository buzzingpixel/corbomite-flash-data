<?php

declare(strict_types=1);

namespace corbomite\flashdata\data\FlashDatum;

/**
 * @property mixed $guid binary(16) NOT NULL
 * @property mixed $name text(65535)
 * @property mixed $data text(65535)
 * @property mixed $added_at datetime NOT NULL
 * @property mixed $added_at_time_zone varchar(255) NOT NULL
 */
trait FlashDatumFields
{
}

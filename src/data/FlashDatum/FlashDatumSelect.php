<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Mapper\MapperSelect;

/**
 * @method FlashDatumRecord|null fetchRecord()
 * @method FlashDatumRecord[] fetchRecords()
 * @method FlashDatumRecordSet fetchRecordSet()
 */
class FlashDatumSelect extends MapperSelect
{
}

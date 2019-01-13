<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Mapper\Record;

/**
 * @method FlashDatumRow getRow()
 */
class FlashDatumRecord extends Record
{
    use FlashDatumFields;
}

<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Table\TableSelect;

/**
 * @method FlashDatumRow|null fetchRow()
 * @method FlashDatumRow[] fetchRows()
 */
class FlashDatumTableSelect extends TableSelect
{
}

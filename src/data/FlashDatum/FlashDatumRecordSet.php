<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\flashdata\data\FlashDatum;

use Atlas\Mapper\RecordSet;

/**
 * @method FlashDatumRecord offsetGet($offset)
 * @method FlashDatumRecord appendNew(array $fields = [])
 * @method FlashDatumRecord|null getOneBy(array $whereEquals)
 * @method FlashDatumRecordSet getAllBy(array $whereEquals)
 * @method FlashDatumRecord|null detachOneBy(array $whereEquals)
 * @method FlashDatumRecordSet detachAllBy(array $whereEquals)
 * @method FlashDatumRecordSet detachAll()
 * @method FlashDatumRecordSet detachDeleted()
 */
class FlashDatumRecordSet extends RecordSet
{
}

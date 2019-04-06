<?php

declare(strict_types=1);

namespace corbomite\flashdata\exceptions;

use Exception;
use Throwable;

class InvalidFlashDataModelException extends Exception
{
    public function __construct(
        string $message = 'The FlashDataModel is invalid',
        int $code = 500,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

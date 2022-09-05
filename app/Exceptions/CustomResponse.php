<?php

declare(strict_types=1);

namespace App\Exceptions;

class CustomResponse
{
    public const CUSTOM_ERROR_CODE = -1;
    public const NOT_FOUND_MODEL_ERROR = 1;
    public const INTERNAL_SERVER_ERROR = 2;
}
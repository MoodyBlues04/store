<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomException extends HttpException
{
    /** @var int $errorCode */
    protected int $errorCode;

    public function __construct(
        string $message = "",
        int $statusCode = 0,
        int $errorCode = CustomResponse::CUSTOM_ERROR_CODE
    ) {
        parent::__construct($statusCode, $message);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}

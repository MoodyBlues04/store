<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class NotFoundModelException extends CustomException
{
    /**
     * Reports the exception
     * @return void
     */
    public function report()
    {
        Log::error('Not found model error', [
            'message' => $this->getMessage(),
            'path' => $this->getFile()
        ]);
    }
}

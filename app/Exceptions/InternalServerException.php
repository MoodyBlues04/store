<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class InternalServerException extends CustomException
{
    /**
     * Reports the exception
     * @return void
     */
    public function report()
    {
        Log::error('Internal server error', [
            'message' => $this->getMessage(),
            'path' => $this->getFile()
        ]);
    }
}

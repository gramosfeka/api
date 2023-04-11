<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function errorResponse(\Exception $ex, int $errorCode = 500)
    {
        \Log::error('Error Message : '.  $ex->getMessage());
        \Log::error('Error Line: '. $ex->getLine());
        \Log::error('Error File: ' .$ex->getFile());


        $code = (array_key_exists($ex->getCode(), Response::$statusTexts)) ? $ex->getCode() : $errorCode;
        return response()->json([
            'type' => 'error',
            'message' => $ex->getMessage(),
            'status' => $ex->getCode(),
        ], $code);
    }
}

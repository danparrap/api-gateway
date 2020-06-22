<?php

namespace App\Traits; 
use Illuminate\Http\Response;

trait ApiResponse 
{
    /**
     * Build a success response
     * @param string|array $data
     * @param int $code
     * @return Illuminate\Http\Response
     */

    public function successResponse($data, $code = Response::HTTP_OK)
    {
        return response($data, $code)->header('Content-type', 'application/json');
    }

    /**
     * Return an error response
     * @param string $message
     * @param int $code
     * @return Illuminate\Http\Response
     */

    public function errorMessage($message, $code)
    {
        return response($message, $code)->header('Content-type', 'application/json');
    }

}
<?php

namespace App\Trait;

trait HandleResponse
{
    public function data(array $data,string $message='' ,int $code=200)
    {
        return response()->json(
            [
                'message'       => $message,
                'data'      => $data,
                'errors'    => (object)[],
            ],$code);
    }


    public function successMessage(string $message = '', int $code = 200)
    {
        return response()->json([
            'message' => $message,
            'errors' => (object)[],
            'data' => (object)[]
        ], $code);
    }



    public function errorsMessage(array $errors, string $message = '', int $code = 404)
    {
        return response()->json(
    [
            'message' => $message,
            'errors' => $errors,
            'data' => (object)[]
        ], $code);
    }



    public function errorsalertMessage(\Throwable $exception, string $message = '', int $code = 500)
{
    $debug = config('app.debug');

    return response()->json([
        'message' => $message,
        'errors' => $debug ? [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine()
        ] : (object)[],
        'data' => (object)[]
    ], $code);
}
}





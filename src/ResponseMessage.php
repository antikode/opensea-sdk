<?php

namespace Masiting\Opensea;

class ResponseMessage
{
    protected static function success_response($data, $code = 200)
    {
        return self::boilerplate_response(true, $code, $data);
    }

    protected static function error_response($errors, $code)
    {
        return self::boilerplate_response(false, $code, $errors);
    }

    /**
     * @param $success
     * @param mixed $code
     * @param $data
     */
    protected static function boilerplate_response($success, int $code, $data)
    {
        return [
            'success' => $success,
            'code' => $code,
            'data' => $data
        ];
    }

}

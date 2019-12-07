<?php

namespace Baraveli\RssScraper\Util;

use Baraveli\RssScraper\Interfaces\IResponseUtil;

class ResponseUtil implements IResponseUtil
{
    /**
     * makeResponse
     *
     * @param  mixed $message
     * @param  mixed $data
     *
     * @return void
     */
    public static function makeResponse($message, $data)
    {
        return [
            'success' => true,
            'data'    => $data,
            'message' => $message
        ];
    }

    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}

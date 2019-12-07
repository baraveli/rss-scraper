<?php

namespace Baraveli\RssScraper\Interfaces;

interface IResponseUtil
{
    
   
    /**
     * makeResponse
     *
     * @param  mixed $message
     * @param  mixed $result
     *
     * @return void
     */
    public static function makeResponse($message, $result);

    /**
     * makeError
     *
     * @param  mixed $message
     * @param  mixed $data
     *
     * @return void
     */
    public static function makeError($message, array $data = []);
}

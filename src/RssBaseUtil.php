<?php

namespace Baraveli\RssScraper;

use Baraveli\RssScraper\Response\Response;
use Baraveli\RssScraper\Util\ResponseUtil;

use Baraveli\RssScraper\Interfaces\IRssBaseUtil;

class RssBaseUtil implements IRssBaseUtil
{

    /**
     * sendResponse
     *
     * @param  mixed $result
     * @param  mixed $message
     *
     * @return void
     */
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * sendError
     *
     * @param  mixed $error
     * @param  mixed $code
     *
     * @return void
     */
    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}

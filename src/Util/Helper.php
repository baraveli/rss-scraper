<?php

namespace Baraveli\RssScraper\Util;

trait Helper
{
    /**
     * isValidXml
     *
     * @param  mixed $content
     *
     * @return void
     */
    public function isValidXml($content)
    {
        $isValid = true;

        $content = trim($content);
        if (empty($content) || stripos($content, '<!DOCTYPE html>') !== false) {
            $isValid = false;
        }
        return $isValid;
    }
}

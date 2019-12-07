<?php

namespace Baraveli\RssScraper\Interfaces;

interface IConfigLoader
{
    public const DIRECTORY_PATH = "./../configs/";

    /**
     * load
     *
     * @param  mixed $filename
     *
     * @return void
     */
    public static function load(string $filename): array;
}

<?php

namespace Gitonomy\ChangeLog\Loader;

class CacheLoader
{
    const DEFAULT_FILE = '/../../../../cache/changelog.json';

    public function load($file = null)
    {
        if (null === $file) {
            $file = self::DEFAULT_FILE;
        }

        return json_decode(file_get_contents(__DIR__.$file), true);
    }
}

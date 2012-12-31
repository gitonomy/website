<?php

namespace Gitonomy\ChangeLog\Loader;

interface LoaderInterface
{
    /**
     * @return Changelog
     */
    public function load();
}

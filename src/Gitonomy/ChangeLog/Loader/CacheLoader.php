<?php

namespace Gitonomy\ChangeLog\Loader;

use Gitonomy\ChangeLog\ChangeLog;

class CacheLoader implements LoaderInterface
{
    protected $file;
    protected $fallback;

    public function __construct(LoaderInterface $fallback, $file)
    {
        $this->fallback = $fallback;
        $this->file     = $file;
    }

    public function load()
    {
        if (file_exists($this->file)) {
            return Changelog::fromArray(json_decode(file_get_contents($this->file), true));
        }

        return $this->refresh();
    }

    public function refresh()
    {
        $changelog = $this->fallback->load();
        file_put_contents($this->file, json_encode($changelog->toArray()));

        return $changelog;
    }
}

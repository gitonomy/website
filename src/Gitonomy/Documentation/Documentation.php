<?php

namespace Gitonomy\Documentation;

class Documentation
{
    const PATH_CONSTRAINT ='#^[\w/]+$#';

    protected $sources;

    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }

    public function get($version, $path)
    {
        if (!preg_match(self::PATH_CONSTRAINT, $path)) {
            throw new \InvalidArgumentException(sprintf('Specified path is not correct "%s"', $path));
        }

        if (!isset($this->sources[$version])) {
            throw new \InvalidArgumentException('Specified version is not correct');
        }

        $filepath = $this->sources[$version].'/'.$path.'.fjson';
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException('Specified path is not correct');
        }

        return new Document(json_decode(file_get_contents($filepath), true));
    }

    public function getVersions()
    {
        return array_keys($this->sources);
    }
}

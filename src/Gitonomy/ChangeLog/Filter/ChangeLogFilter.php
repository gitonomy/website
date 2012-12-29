<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\ChangeLog;

class ChangeLogFilter
{
    protected $versionFilter;

    public function __construct(VersionFilter $versionFilter = null)
    {
        $this->versionFilter = $versionFilter;
    }

    public function filter(ChangeLog $changeLog)
    {
        $result = new ChangeLog();

        foreach ($changeLog->getVersions() as $version) {
            if ($this->versionFilter->isTrue($version)) {
                $result->addVersion($this->versionFilter->filter($version));
            }
        }

        return $result;
    }
}

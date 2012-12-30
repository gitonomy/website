<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\ChangeLog;

class ChangeLogFilter
{
    protected $versionFilter;

    public function __construct(VersionFilter $versionFilter)
    {
        $this->versionFilter = $versionFilter;
    }

    public function filter(ChangeLog $changeLog)
    {
        $result = new ChangeLog();

        foreach ($changeLog->getVersions() as $version) {
            $filter = $this->versionFilter->filter($version);

            if (null !== $filter) {
                $result->addVersion($filter);
            }
        }

        return $result;
    }
}

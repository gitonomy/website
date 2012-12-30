<?php

namespace Gitonomy\ChangeLog;

use Gitonomy\ChangeLog\Node\Version;

class ChangeLog
{
    protected $versions;

    public function getVersions()
    {
        return $this->versions;
    }

    public function addVersion(Version $version)
    {
        if (!is_array($this->versions)) {
            $this->versions = array();
        }

        array_push($this->versions, $version);

        return $this;
    }

    public function getLastStableVersion()
    {
        foreach ($this->getVersions() as $version) {
            if (null !== $version->getDate()) {
                return $version;
            }
        }
    }
}

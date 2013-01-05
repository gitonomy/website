<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Version;

class VersionFilter
{
    protected $minimumVersion;

    public function __construct($minimumVersion)
    {
        $this->minimumVersion = $minimumVersion;
    }

    public function filter(Version $version)
    {
        if (!$this->isTrue($version)) {
            return;
        }

        $result = new Version($version->getVersion(), $version->getDate());

        foreach ($version->getFeatures() as $feature) {
            $result->addFeature($feature);
        }

        return $result;
    }

    protected function isTrue(Version $version)
    {
        return version_compare($this->minimumVersion, $version->getVersion()) < 0;
    }
}

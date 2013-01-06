<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Version;

class VersionFilter
{
    protected $minimumVersion;
    protected $stable;

    public function __construct($minimumVersion, $stable = true)
    {
        $this->minimumVersion = $minimumVersion;
        $this->stable         = (bool)$stable;
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
        return (
            (!$this->stable && null === $version->getDate()) ||
            (version_compare($this->minimumVersion, $version->getVersion()) < 0 && null !== $version->getDate())
        );
    }
}

<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Version;

class VersionFilter
{
    protected $lastVersion;
    protected $executed;

    public function __construct($lastVersion = null, FeatureFilter $featureFilter = null)
    {
        $this->executed      = false;
        $this->lastVersion   = $lastVersion;
        $this->featureFilter = $featureFilter;
    }

    public function filter(Version $version)
    {
        if ($version->getVersion() === $this->lastVersion) {
            $this->executed = true;
        }

        if ($this->isTrue($version)) {
            $result = new Version($version->getVersion(), $version->getDate());

            foreach ($version->getFeatures() as $feature) {
                if (null === $this->featureFilter) {
                    $result->addFeature($feature);
                } elseif ($this->featureFilter->isTrue($feature)) {
                    $result->addFeature($this->featureFilter->filter($feature));
                }
            }

            return $result;
        }

        return;
    }

    public function isTrue(Version $version)
    {
        return !$this->executed;
    }
}

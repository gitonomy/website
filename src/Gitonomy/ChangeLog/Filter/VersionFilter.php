<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Version;

class VersionFilter
{
    protected $featureFilter;
    protected $lastVersion;
    protected $executed;

    public function __construct($lastVersion)
    {
        $this->executed    = false;
        $this->lastVersion = $lastVersion;
    }

    public function setFeatureFilter(FeatureFilter $featureFilter)
    {
        $this->featureFilter = $featureFilter;
    }

    public function filter(Version $version)
    {
        if ($this->isTrue($version)) {
            $result = new Version($version->getVersion(), $version->getDate());

            foreach ($version->getFeatures() as $feature) {
                if (null === $this->featureFilter) {
                    $result->addFeature($feature);
                } elseif (null !== $filter = $this->featureFilter->filter($feature)) {
                    $result->addFeature($filter);
                }
            }

            return $result;
        }

        return;
    }

    protected function isTrue(Version $version)
    {
        if ($version->getVersion() === $this->lastVersion) {
            $this->executed = true;
        }

        return !$this->executed;
    }
}

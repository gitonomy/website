<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Version;

class VersionFilter
{
    protected $featureFilter;
    protected $minimumVersion;

    public function __construct($minimumVersion)
    {
        $this->minimumVersion = $minimumVersion;
    }

    public function setFeatureFilter(FeatureFilter $featureFilter)
    {
        $this->featureFilter = $featureFilter;
    }

    public function filter(Version $version)
    {
        if (!$this->isTrue($version)) {
            return;
        }

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

    protected function isTrue(Version $version)
    {
        return version_compare($this->minimumVersion, $version->getVersion()) < 0;
    }
}

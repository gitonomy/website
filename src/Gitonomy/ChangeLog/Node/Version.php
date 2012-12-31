<?php

namespace Gitonomy\ChangeLog\Node;

class Version
{
    protected $version;
    protected $date;
    protected $features;

    public function __construct($version, $date = null)
    {
        $this->version  = $version;
        $this->date     = $date;
        $this->features = array();
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getFeatures()
    {
        return $this->features;
    }

    public function addFeature(Feature $feature)
    {
        array_push($this->features, $feature);

        return $this;
    }

    public function toArray()
    {
        $version = array(
            'version'  => $this->getVersion(),
            'date'     => $this->getDate(),
            'features' => array(),
        );

        foreach ($this->getFeatures() as $feature) {
            array_push($version['features'], $feature->toArray());
        }

        return $version;
    }

    static public function fromArray(array $array)
    {
        $version = new Version($array['version'], $array['date']);

        foreach ($array['features'] as $feature) {
            $version->addFeature(Feature::fromArray($feature));
        }

        return $version;
    }
}

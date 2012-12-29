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
}

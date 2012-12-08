<?php

namespace Gitonomy\ChangeLog\Node;

class Feature
{
    protected $level;
    protected $feature;

    public function __construct($level, $feature)
    {
        $this->level   = $level;
        $this->feature = $feature;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getFeature()
    {
        return $this->feature;
    }
}

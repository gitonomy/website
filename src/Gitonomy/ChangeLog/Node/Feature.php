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

    public function toArray()
    {
        return array(
            'level'   => $this->getLevel(),
            'feature' => $this->getFeature(),
        );
    }

    static public function fromArray(array $array)
    {
        return new Feature($array['level'], $array['feature']);
    }
}

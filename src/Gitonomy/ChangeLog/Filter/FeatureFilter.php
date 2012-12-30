<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Feature;

class FeatureFilter
{
    protected $levels;

    public function __construct($levels = null)
    {
        $this->levels = $levels;
    }

    public function filter($feature)
    {
        if ($this->isTrue($feature)) {
            return $feature;
        }

        return;
    }

    protected function isTrue(Feature $feature)
    {
        return null === $this->levels || in_array($feature->getLevel(), $this->levels);
    }
}

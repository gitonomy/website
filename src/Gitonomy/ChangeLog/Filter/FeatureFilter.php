<?php

namespace Gitonomy\ChangeLog\Filter;

use Gitonomy\ChangeLog\Node\Feature;

class FeatureFilter
{
    protected $levels;

    public function __construct(array $levels = null)
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

    public function isTrue(Feature $feature)
    {
        return in_array($feature->getLevel(), $this->levels);
    }
}

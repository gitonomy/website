<?php

namespace Gitonomy\ChangeLog\Filter;

use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    static function createFromRequest(Request $request)
    {
        $parameters      = $request->query;
        $versionFilter   = null;
        $featureFilter   = null;
        $changeLogFilter = null;

        if ($parameters->has('levels')) {
            $levels = explode(',', $parameters->get('levels'));
            $featureFilter = new FeatureFilter($levels);
        }

        if ($parameters->has('from_version')) {
            $versionFilter = new VersionFilter($parameters->get('from_version'), $featureFilter);
        }

        return null !== $versionFilter ? new ChangeLogFilter($versionFilter) : null;
    }
}

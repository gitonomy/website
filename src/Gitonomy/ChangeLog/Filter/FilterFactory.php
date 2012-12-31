<?php

namespace Gitonomy\ChangeLog\Filter;

use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    static function createFromRequest(Request $request)
    {
        $parameters = $request->query;

        $version       = $parameters->get('from_version', 0.0);
        $versionFilter = new VersionFilter($version);

        if ($parameters->has('levels')) {
            $levels        = explode(',', $parameters->get('levels'));
            $featureFilter = new FeatureFilter($levels);

            $versionFilter->setFeatureFilter($featureFilter);
        }

        return new ChangeLogFilter($versionFilter);
    }
}

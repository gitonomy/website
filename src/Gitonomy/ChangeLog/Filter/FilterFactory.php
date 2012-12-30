<?php

namespace Gitonomy\ChangeLog\Filter;

use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    static function createFromRequest(Request $request)
    {
        $parameters = $request->query;

        $version       = $parameters->get('from_version', null);
        $versionFilter = new VersionFilter($version);

        $levels        = explode(',', $parameters->get('levels', array()));
        $featureFilter = new FeatureFilter($levels);

        $versionFilter->setFeatureFilter($featureFilter);

        return new ChangeLogFilter($versionFilter);
    }
}

<?php

namespace Gitonomy\ChangeLog\Filter;

use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    static function createFromRequest(Request $request)
    {
        $parameters = $request->query;

        $version = $parameters->get('from_version', 0.0);
        $filter  = new VersionFilter($version);

        return new ChangeLogFilter($filter);
    }
}

<?php

namespace Gitonomy\ChangeLog\Filter;

use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    static function createFromRequest(Request $request)
    {
        $parameters = $request->query;

        $version = $parameters->get('from_version', 0.0);
        $stable = $parameters->get('stable', true);
        $filter  = new VersionFilter($version, ($stable === 'false' ? false : $stable));

        return new ChangeLogFilter($filter);
    }
}

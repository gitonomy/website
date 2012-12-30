<?php

namespace Gitonomy\ChangeLog;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Filter\ChangeLogFilter;
use Gitonomy\ChangeLog\Loader\CacheLoader;
use Gitonomy\ChangeLog\Loader\GithubLoader;
use Gitonomy\ChangeLog\Transformer\RstTransformer;
use Gitonomy\ChangeLog\Transformer\ArrayTransformer;

class ChangeLogFactory
{
    static function getCache(ChangeLogFilter $filter = null)
    {
        $loader = new CacheLoader();
        $cache  = $loader->load();

        $converter = new ArrayTransformer();
        $changeLog = $converter->transform($cache);

        return null === $filter ? $changeLog : $filter->filter($changeLog);
    }

    static function createFromGithub($url = null)
    {
        $loader = new GithubLoader();
        $rst = $loader->load($url);

        $converter = new RstTransformer();

        return $converter->transform($rst);
    }

    static function toArray(ChangeLog $changeLog)
    {
        $converter = new ArrayTransformer();

        return $converter->reverseTransform($changeLog);
    }

    static function toJson(ChangeLog $changeLog)
    {
        return json_encode(self::toArray($changeLog));
    }
}

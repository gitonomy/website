<?php

namespace Gitonomy\ChangeLog;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Loader\GithubLoader;
use Gitonomy\ChangeLog\Transformer\RstTransformer;
use Gitonomy\ChangeLog\Transformer\ArrayTransformer;

class ChangeLogFactory
{
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

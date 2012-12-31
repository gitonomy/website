<?php

namespace Gitonomy;

use Silex\Application as SilexApplication;

use Gitonomy\ChangeLog\Loader\CacheLoader;
use Gitonomy\ChangeLog\Loader\GithubLoader;
use Gitonomy\Documentation\Documentation;

class Application extends SilexApplication
{
    public function __construct()
    {
        parent::__construct();

        $app = $this;

        $this['gitlib.documentation'] = function ($app) {
            return new Documentation(array(
                'master' => __DIR__.'/../../cache/doc/gitlib/json/master'
            ));
        };

        $this['gitonomy.changelog.cache'] = function ($app) {
            return new CacheLoader(new GithubLoader(), __DIR__.'/../../cache/changelog.json');
        };

        $this['gitonomy.changelog'] = function ($app) {
            return $app['gitonomy.changelog.cache']->load();
        };
    }
}

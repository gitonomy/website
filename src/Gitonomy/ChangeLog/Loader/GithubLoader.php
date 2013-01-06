<?php

namespace Gitonomy\ChangeLog\Loader;

use Buzz\Browser;
use Buzz\Client\Curl;

use Gitonomy\ChangeLog\Parser\ChangeLogParser;

class GithubLoader implements LoaderInterface
{
    const URL = 'http://github.com/gitonomy/gitonomy/raw/master/CHANGELOG.md';

    public function load()
    {
        $browser = new Browser(new Curl());
        $browser->get(self::URL);
        $response = $browser->getLastResponse();

        if (!$response->isSuccessful()) {
            throw new \LogicException($response->getStatusCode().' - '.$response->getReasonPhrase());
        }

        $content = $response->getContent();
        $parser  = new ChangeLogParser();

        return $parser->parse($content);
    }
}

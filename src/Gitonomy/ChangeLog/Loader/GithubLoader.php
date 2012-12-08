<?php

namespace Gitonomy\ChangeLog\Loader;

use Buzz\Browser;
use Buzz\Client\Curl;

class GithubLoader
{
    const DEFAULT_URL = 'http://github.com/gitonomy/gitonomy/raw/master/CHANGELOG.md';

    public function load($url = null)
    {
        if (null === $url) {
            $url = self::DEFAULT_URL;
        }

        $browser = new Browser(new Curl());
        $browser->get($url);
        $response = $browser->getLastResponse();

        if (!$response->isSuccessful()) {
            throw new \LogicException($response->getStatusCode().' - '.$response->getReasonPhrase());
        }

        return $response->getContent();
    }
}

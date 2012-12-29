<?php

namespace Gitonomy\ChangeLog\Transformer;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Node\Feature;
use Gitonomy\ChangeLog\Node\Version;
use Gitonomy\ChangeLog\Parser\Parser;

class RstTransformer
{
    public function transform($string)
    {
        $changeLog = new ChangeLog();

        $parser = new Parser();
        $parser->parse($string);

        while (!$parser->isFinished()) {

            if ($parser->expects('* ')) {
                $version = $parser->consumeTo("\n");

                preg_match('#(?P<version>[^/]+) \((?P<date>[0-9]{4}-[0-9]{2}-[0-9]{2})\)#', $version, $versionData);

                if (array() === $versionData) {
                    $version = new Version($version);
                } else {
                    $version = new Version($versionData['version'], $versionData['date']);
                }

                $changeLog->addVersion($version);
            }

            if ($parser->expects('  * ')) {
                $feature = $parser->consumeTo("\n");

                preg_match('#(?P<level>\w+) (?P<feature>[^.]+)#', $feature, $featureData);

                if (null === $version) {
                    continue;
                }

                $version->addFeature(new Feature($featureData['level'], $featureData['feature']));
            }

            $parser->consumeNewLine();
        }

        return $changeLog;
    }
}

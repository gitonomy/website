<?php

namespace Gitonomy\ChangeLog\Transformer;

use Symfony\Component\CssSelector\CssSelector;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Node\Feature;
use Gitonomy\ChangeLog\Node\Version;

class XmlToChangeLogTransformer
{
    public function transform(\DOMDocument $document)
    {
        $xpath     = new \DOMXPath($document);
        $changeLog = new ChangeLog();
        $nodes     = $xpath->query(CssSelector::toXPath('document > bullet_list > list_item'));

        foreach ($nodes as $node) {
            $version = $node->getElementsByTagName('paragraph')->item(0)->textContent;
            preg_match('#(?P<version>[^/]+) \((?P<date>[0-9]{4}-[0-9]{2}-[0-9]{2})\)#', $version, $versionData);

            $version = new Version($versionData['version'], $versionData['date']);
            $changeLog->addVersion($version);

            foreach ($node->getElementsByTagName('list_item') as $childNode) {
                $feature = $childNode->getElementsByTagName('paragraph')->item(0)->textContent;
                preg_match('#(?P<level>\w+) (?P<feature>[^.]+)#', $feature, $featureData);

                $version->addFeature(new Feature($featureData['level'], $featureData['feature']));
            }
        }

        return $changeLog;
    }
}

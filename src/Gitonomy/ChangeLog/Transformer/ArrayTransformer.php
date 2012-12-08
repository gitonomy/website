<?php

namespace Gitonomy\ChangeLog\Transformer;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Node\Feature;
use Gitonomy\ChangeLog\Node\Version;

class ArrayTransformer
{
    public function transform($content)
    {
        $changeLog = new ChangeLog();

        foreach ($content as $data) {
            $date = \DateTime::createFromFormat('Y-m-d', $data['date']);
            $version = new Version($data['version'], $date);
            $changeLog->addVersion($version);

            foreach ($data['features'] as $feature) {
                $version->addFeature(new Feature($feature['level'], $feature['feature']));
            }
        }

        return $changeLog;
    }

    public function reverseTransform(ChangeLog $changeLog)
    {
        $versions = array();

        foreach ($changeLog->getVersions() as $version) {
            $data = array(
                'version'  => $version->getVersion(),
                'date'     => $version->getDate()->format('Y-m-d'),
                'features' => array(),
            );

            foreach ($version->getFeatures() as $feature) {
                array_push($data['features'], array(
                    'level'   => $feature->getLevel(),
                    'feature' => $feature->getFeature(),
                ));
            }

            array_push($versions, $data);
        }

        return $versions;
    }
}

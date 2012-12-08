<?php

namespace Gitonomy\ChangeLog\Transformer;

use Gitonomy\ChangeLog\ChangeLog;

class ArrayTransformer
{
    public function reverseTransform(ChangeLog $changeLog)
    {
        $versions = array();

        foreach ($changeLog->getVersions() as $version) {
            $data = array(
                'version'  => $version->getVersion(),
                'date'     => $version->getDate(),
                'features' => array(),
            );

            foreach ($version->getFeatures() as $feature) {
                array_push($data['features'], array(
                    'level' => $feature->getLevel(),
                    'feature' => $feature->getFeature(),
                ));
            }

            array_push($versions, $data);
        }

        return $versions;
    }
}

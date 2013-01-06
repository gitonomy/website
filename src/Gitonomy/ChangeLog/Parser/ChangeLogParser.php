<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\ChangeLog\Parser;

use Gitonomy\ChangeLog\ChangeLog;
use Gitonomy\ChangeLog\Node\Version;
use Gitonomy\ChangeLog\Node\Feature;

class ChangeLogParser extends Parser
{
    public function parse($content)
    {
        $this->cursor  = 0;
        $this->content = $content;
        $this->length  = strlen($this->content);

        $changeLog = new ChangeLog();

        while (!$this->isFinished()) {

            if ($this->expects('* ')) {
                $version = $this->parseVersion($changeLog);
            }

            if (null !== $version && $this->expects('  * ')) {
                $this->parseFeature($version);
            }

            $this->consumeNewLine();
        }

        return $changeLog;
    }

    protected function parseVersion(ChangeLog $changeLog)
    {
        $version = $this->consumeTo("\n");

        preg_match('/^v([0-9\.]+)(?: \((\d{4}-\d{2}-\d{2})\))?$/', $version, $versionData);

        if (!$versionData) {
            $version = new Version($version);
        }
        elseif (isset($versionData[2])) {
            $version = new Version($versionData[1], $versionData[2]);
        } else {
            $version = new Version($versionData[1]);
        }

        $changeLog->addVersion($version);

        return $version;
    }

    protected function parseFeature(Version $version)
    {
        $feature = $this->consumeTo("\n");

        preg_match('#(\w*) (.*)#', $feature, $featureData);

        if (!$featureData) {
            return;
        }

        $version->addFeature(new Feature($featureData[1], $featureData[2]));

        return $feature;
    }
}

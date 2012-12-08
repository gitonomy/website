<?php

namespace Gitonomy\ChangeLog\Transformer;

class RstToXmlTransformer
{
    public function transform($content)
    {
        $command = 'rst2xml --no-toc-backlinks --no-doc-title --no-generator --no-source-link --no-footnote-backlinks --strip-comments';

        $ioDescription = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
        );

        $proc = proc_open($command, $ioDescription, $pipes, '/tmp', NULL);

        if (!is_resource($proc)) {
            throw new \LogicException('proc_open failed');
        }

        fwrite($pipes[0], $content);
        fflush($pipes[0]);
        fclose($pipes[0]);

        $xml = stream_get_contents($pipes[1]);

        proc_close($proc);

        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadXML($xml);

        return $document;
    }
}

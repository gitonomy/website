<?php

namespace Gitonomy\ChangeLog\Transformer;

class RstTransformer
{
    public function transform($content)
    {
        $transformer = new RstToXmlTransformer();
        $xml = $transformer->transform($content);

        $transformer = new XmlToChangeLogTransformer();
        $changeLog = $transformer->transform($xml);

        return $changeLog;
    }
}

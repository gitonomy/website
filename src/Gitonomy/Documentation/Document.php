<?php

namespace Gitonomy\Documentation;

class Document
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getTitle()
    {
        return $this->data['title'];
    }

    public function getBody()
    {
        $body = $this->data['body'];

        //$body = preg_replace('~href="([^"]+)/(#[\w-]+)?">~', 'href="$1$2">', $body);

        return $body;
    }

    public function getToc()
    {
        return $this->data['toc'];
    }

    public function getParents()
    {
        $parents = array();

        foreach ($this->data['parents'] as $parent) {
            $parents[] = array(
                'text' => $parent['title'],
                'path' => $parent['link']
            );
        }

        return $parents;
    }

    public function hasNext()
    {
        return $this->data['next'] !== null;
    }

    public function getNextLink()
    {
        return $this->data['next']['link'];
    }

    public function getNextTitle()
    {
        return $this->data['next']['title'];
    }

    public function hasPrev()
    {
        return $this->data['prev'] !== null;
    }

    public function getPrevLink()
    {
        return $this->data['prev']['link'];
    }

    public function getPrevTitle()
    {
        return $this->data['prev']['title'];
    }
}

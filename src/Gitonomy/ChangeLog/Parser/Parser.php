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

abstract class Parser
{
    protected $cursor;
    protected $content;
    protected $length;

    abstract function parse($content);

    public function isFinished()
    {
        return $this->cursor === $this->length;
    }

    public function expects($expected)
    {
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual !== $expected) {
            return false;
        }

        $this->cursor += $length;

        return true;
    }

    public function consumeRegexp($regexp)
    {
        if (!preg_match($regexp.'A', $this->content, $vars, null, $this->cursor)) {
            throw new \RuntimeException('No match for regexp '.$regexp);
        }

        $this->cursor += strlen($vars[0]);

        return $vars;
    }

    public function consumeTo($text)
    {
        $pos = strpos($this->content, $text, $this->cursor);

        if (false === $pos) {
            throw new \RuntimeException(sprintf('Unable to find "%s"', $text));
        }

        $result = substr($this->content, $this->cursor, $pos - $this->cursor);
        $this->cursor = $pos;

        return $result;
    }

    public function consume($expected)
    {
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual !== $expected) {
            throw new \RuntimeException(sprintf('Expected "%s", but got "%s"', $expected, $actual));
        }
        $this->cursor += $length;

        return $expected;
    }

    public function consumeNewLine()
    {
        return $this->consume("\n");
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 06.04.18
 * Time: 14:40
 */

namespace Phore\Html\Elements;


class RawHtmlNode implements HtmlElementNode
{
    use ParentNodeTrait;

    private $value;

    public function __construct($value = "")
    {
        $this->value = $value;
    }

    public function render($indent = "  ", $index = 0): string
    {
        return $this->value;
    }
}
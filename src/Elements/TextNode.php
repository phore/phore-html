<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:48
 */

namespace Phore\Html\Elements;


class TextNode implements HtmlElementNode
{
    use ParentNodeTrait;

    protected $text;

    public function __construct($text = "")
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function render($indent = "  ", $index = 0): string
    {
        return htmlentities($this->text);
    }
}
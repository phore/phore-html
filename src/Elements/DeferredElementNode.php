<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.04.18
 * Time: 16:14
 */

namespace Phore\Html\Elements;


class DeferredElementNode implements HtmlElementNode
{

    private $function;

    private $parent;
    public function __construct(callable $function)
    {
        $this->function = $function;
    }

    public function render($indent = "  ", $index = 0): string
    {
        $node = ($this->function)();
        if ( ! $node instanceof HtmlElementNode)
            throw new \InvalidArgumentException("DeferredElementNode must return HtmlElemenetNode");
        return $node->render($indent, $index);
    }

    public function _setParent(HtmlContainerElement $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): HtmlContainerElement
    {
        return $this->parent;
    }
}
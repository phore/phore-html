<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 19.04.18
 * Time: 14:26
 */

namespace Phore\Html\Fhtml;


use HtmlTheme\Elements\HtmlContainerElement;
use HtmlTheme\Elements\HtmlElementNode;
use HtmlTheme\Elements\RawHtmlNode;
use HtmlTheme\Elements\TextNode;

/**
 * Trait _FHtmlTemplateTrait
 *
 * @package HtmlTheme\Fhtml

 *
 */
trait _FHtmlTemplateTrait
{

    private function _addStructRecursive ($node, FHtml $pointer) : void
    {
        if ($node instanceof RawHtmlNode) {
            $pointer->curNode->add($node);
            return;
        }
        if (is_callable($node)) {
            $ret = $node($pointer);
            if ($ret instanceof HtmlElementNode)
                $pointer->curNode->add($ret);
            return;
        }
        if (is_string($node)) {
            if ($pointer->curNode instanceof HtmlContainerElement)
                $pointer->curNode->add(new TextNode($node));
            return;
        }
        if ($node === null || $node === false )
            return;

        foreach ($node as $key => $value) {
            if (is_string($key)) {
                $this->_addStructRecursive($value, $pointer->elem($key));
                //if ($pointer->curNode !== $pointer->documentNode)
                //    $pointer->end();
            }
            if (is_int($key)) {
                $this->_addStructRecursive($value, $pointer);
            }
        }
        return;
    }

    public function tpl(array $input) : self
    {
        $this->_addStructRecursive($input, $this);
        return $this;
    }
}
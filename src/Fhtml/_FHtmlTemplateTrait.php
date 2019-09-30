<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 19.04.18
 * Time: 14:26
 */

namespace Phore\Html\Fhtml;


use Phore\Html\Elements\HtmlContainerElement;
use Phore\Html\Elements\HtmlElementNode;
use Phore\Html\Elements\RawHtmlNode;
use Phore\Html\Elements\TextNode;

/**
 * Trait _FHtmlTemplateTrait
 *
 * @package HtmlTheme\Fhtml

 *
 */
trait _FHtmlTemplateTrait
{

    private function _addStructRecursive ($node, FHtml $pointer, array $arguments, array $path=[]) : void
    {
        if ($node instanceof HtmlElementNode) {
            $pointer->curNode->add($node);
            return;
        }
        if ($node instanceof \Closure) {
            $ret = $node($pointer);
            $pointer->tpl($ret, $arguments);
            return;
        }
        if (is_string($node)  || is_int($node) || is_float($node)) {
            if ($pointer->curNode instanceof HtmlContainerElement)
                $pointer->curNode->add(new TextNode($node));
            return;
        }
        if ($node === null || $node === false )
            return;

        if ( ! is_array($node))
            throw new \InvalidArgumentException("Invalid node: '" . print_r ($node, true) . "' (not an array) in element " . implode (" > ", $path) );

        foreach ($node as $key => $value) {
            if (is_string($key)) {
                $path[] = $key;
                $this->_addStructRecursive($value, $pointer->elem($key, $arguments), $arguments, $path);
                //if ($pointer->curNode !== $pointer->documentNode)
                //    $pointer->end();
                continue;
            }
            if (is_int($key)) {
                $path[] = $key;
                $this->_addStructRecursive($value, $pointer, $arguments);
                continue;
            }
            if ($value instanceof HtmlElementNode) {
                $pointer->curNode->add($value);
                continue;
            }
            throw new \InvalidArgumentException("Cannot append node '$key'");

        }
        return;
    }

    protected function tpl($input, array $arguments) : self
    {
        $this->_addStructRecursive($input, $this, $arguments);
        return $this;
    }
}

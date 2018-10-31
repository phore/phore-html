<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:41
 */

namespace Phore\Html\Elements;


class HtmlContainerElement extends HtmlElement
{

    /**
     * @var HtmlElementNode[]
     */
    protected $children = [];

    public function add(HtmlElementNode $child)
    {
        $this->children[] = $child;
        $child->_setParent($this);

        if ($child instanceof DocumentNode) {
            $this->getRootDocument()->__addToIndex($child);
            return;
        }
        if ($child instanceof HtmlElement) {
            $id = $child->getAttrib("id");
            if ($id !== null)
                $this->getRootDocument()->__addToIndex($child);
        }
    }

    /**
     * @return HtmlElementNode[]
     */
    public function getChildren ()
    {
        return $this->children;
    }


    public function clearChildren ()
    {
        $this->children = [];
    }


    public function walkChildren (callable $fn)
    {
        foreach ($this->children as $curChild) {
            if ($fn($curChild) === false)
                return false;
            if ($curChild instanceof HtmlContainerElement)
                if ($curChild->walkChildren($fn) === false)
                    return false;
        }
        return true;
    }


    public function render($indent = "  ", $index=0): string
    {
        $block = "";
        if ($indent !== false) {
            $ii = str_repeat($indent, $index);
            $block = "\n$ii";
        }

        $block .= "<{$this->tag}{$this->renderAttrs($this->attrs)}>";
        if (count ($this->children) === 0)
            return $block . "</{$this->tag}>";

        $childContent = "";
        foreach($this->children as $curChild) {
            $childContent .= $curChild->render($indent, $index + 1);
        }
        $block .= $childContent;
        if (strpos($childContent, "\n") !== false && $indent !== false) {
            $block .= "\n$ii";
        }
        $block .= "</{$this->tag}>";
        return $block;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 18:27
 */

namespace Phore\Html\Elements;


class DocumentNode extends HtmlContainerElement
{
    use ParentNodeTrait;

    protected $processingInstruction = "";

    protected $indexById = [];

    public function getParent(): HtmlContainerElement
    {
        if ($this->parent !== null)
            return $this->parent;
        return $this;
    }

    public function __addToIndex(HtmlElement $element)
    {
        if ($element instanceof DocumentNode) {
            $this->indexById = array_merge($this->indexById, $element->indexById);
            return;
        }
        if ($element instanceof HtmlElement) {
            $this->indexById[$element->getAttrib("id")] = $element;
            return;
        }
    }

    public function getElementById ($id) : HtmlElement
    {
        if ( ! isset ($this->indexById[$id]))
            throw new \InvalidArgumentException("Query element id '$id': No element found.");
        return $this->indexById[$id];
    }

    public function __construct()
    {
        parent::__construct("", []);
    }

    public function setProcessingInstruction ($data)
    {
        $this->processingInstruction = $data;
    }

    /**
     *
     * Parameter1:
     *  - if null: no indention or line-feed at all.
     *
     * @param string $indent
     * @param int $index
     * @return string
     */
    public function render($indent = "  ", $index = 0): string
    {
        $ret = $this->processingInstruction;
        foreach ($this->children as $curChild)
            $ret .= $curChild->render($indent, $index);
        return $ret;
    }



}
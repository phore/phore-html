<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 18:42
 */

namespace Phore\Html\Elements;


trait ParentNodeTrait
{
    protected $parent = null;

    public function _setParent(HtmlContainerElement $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): HtmlContainerElement
    {
        return $this->parent;
    }

    public function getRootDocument() : DocumentNode
    {
        if ($this instanceof DocumentNode && $this->parent === null)
            return $this;
        return $this->getParent()->getRootDocument();
    }

    public function getDocument() : DocumentNode
    {
        if ($this instanceof DocumentNode)
            return $this;
        return $this->getParent()->getDocument();
    }
}
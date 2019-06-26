<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:41
 */

namespace Phore\Html\Elements;


class HtmlElement implements HtmlElementNode
{
    protected $tag;
    protected $attrs;

    use ParentNodeTrait;

    public function __construct($tag, array $attrs)
    {
        $this->tag = $tag;
        $this->attrs = $attrs;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function addAttrib (string $name, string $value) : self
    {
        if (isset ($this->attrs[$name]))
            $this->attrs[$name] .= " $value";
        else
            $this->attrs[$name] = $value;
        return $this;
    }

    public function setAttrib (string $name, string $value) : self
    {
        $this->attrs[$name] = $value;
        return $this;
    }

    public function getAttrib ($name)
    {
        if ( ! isset ($this->attrs[$name]))
            return null;
        return $this->attrs[$name];
    }

    public function getAttribs () : array
    {
        return $this->attrs;
    }

    public function remAttrib (string $name)
    {
        unset ($this->attrs[$name]);
    }

    public function addCssClass (string $className)
    {
        if ( ! isset ($this->attrs["class"]))
            $this->attrs["class"] = "";
        $this->attrs["class"] .= " $className";
    }

    public function remCssClass (string $className)
    {
        if ( ! isset ($this->attrs["class"]))
            return;
        $new = [];

        foreach (explode(" ", $this->attrs["class"]) as $curClass) {
            if ($curClass == "")
                continue;
            if ($curClass == $className)
                continue;
            $new[] = $curClass;
        }
        $this->attrs["class"] = implode(" ", $new);
    }




    public function renderAttrs (array $attribs) : string
    {
        $ret = "";
        foreach ($attribs as $attrName => $value) {
            $ret .= " " . htmlspecialchars($attrName) . "=\"" . htmlspecialchars($value) . "\"";
        }
        return $ret;
    }


    public function render ($indent="  ", $index = 0) : string
    {
        $pre = "";
        if ($indent !== false) {
            $ii = str_repeat($indent, $index);
            $pre = "\n$ii";
        }
        return "{$pre}<{$this->tag}{$this->renderAttrs($this->attrs)}/>";
    }


}
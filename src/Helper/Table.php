<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 24.04.18
 * Time: 12:10
 */

namespace Phore\Html\Helper;


use Phore\Html\Elements\HtmlContainerElement;
use Phore\Html\Elements\HtmlElementNode;

class Table implements HtmlElementNode
{

    /**
     * @var array
     */
    private $header;

    private $rows = [];

    private $source = null;

    public function __construct($header)
    {
        $this->header = $header;
    }

    public static function Create(array $header) : self
    {
        return new self($header);
    }

    private $cssStyles = [
        "table" => "table table-bordered",
        "row-tr"
    ];

    public function row(array $data, string $attrs="", array $args=[]) : self {
        $this->rows[] = [$data, $attrs, $args];
        return $this;
    }


    public function source(callable $source) : self
    {
        $this->source = $source;
        return $this;
    }


    public function setStyle($element, $cssClasses) : self
    {
        if ( ! isset ($this->cssStyles[$element]))
            throw new \InvalidArgumentException("Invalid elementName: '$element'. Available for styling: " . implode (",", array_keys($this->cssStyles)));
        $this->cssStyles[$element] = $cssClasses;
        return $this;
    }


    private $parent;

    public function render($indent = "  ", $index = 0): string
    {
        if ($this->source !== null)
            ($this->source)($this);
        $table = fhtml("table @class=:table", $this->cssStyles);
        $headTr = $table["thead"]["tr"];
        foreach ($this->header as $cur) {
            $headTr[] = ["td" => $cur];
        }
        $tbody = $table["tbody"];
        foreach ($this->rows as $row) {
            $tr = $tbody["tr $row[1]"] = $row[2];
            foreach ($row[0] as $col) {
                $tr[] = ["td" => $col];
            }
        }
        return $table->render($indent, $index);
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

<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 19.04.18
 * Time: 14:28
 */

namespace Phore\Html\Fhtml;


/**
 * Trait _FHtmlCallTrait
 *
 *
 *
 * @package HtmlTheme\Fhtml
 *
 *
 * @method $this   div(string $attrs="", array $args=[])
 * @method $this    ul(string $attrs="", array $args=[])
 * @method $this    li(string $attrs="", array $args=[])
 * @method $this     a(string $attrs="", array $args=[])
 * @method $this input(string $attrs="", array $args=[])
 * @method $this     p(string $attrs="", array $args=[])
 * @method $this     b(string $attrs="", array $args=[])
 * @method $this    h1(string $attrs="", array $args=[])
 * @method $this    h2(string $attrs="", array $args=[])
 * @method $this    h3(string $attrs="", array $args=[])
 * @method $this    h4(string $attrs="", array $args=[])
 * @method $this    hr(string $attrs="", array $args=[])
 * @method $this   nav(string $attrs="", array $args=[])
 * @method $this   img(string $attrs="", array $args=[])
 * @method $this     i(string $attrs="", array $args=[])
 * @method $this   pre(string $attrs="", array $args=[])
 * @method $this  code(string $attrs="", array $args=[])
 * @method $this table(string $attrs="", array $args=[])
 * @method $this thead(string $attrs="", array $args=[])
 * @method $this tbody(string $attrs="", array $args=[])
 * @method $this    td(string $attrs="", array $args=[])
 * @method $this    tr(string $attrs="", array $args=[])
 * @method $this  link(string $attrs="", array $args=[])
 * @method $this script(string $attrs="", array $args=[])
 * @method $this canvas(string $attrs="", array $args=[])
 * @method $this header(string $attrs="", array $args=[])
 * @method $this button(string $attrs="", array $args=[])
 * @method $this   span(string $attrs="", array $args=[])
 * @method $this   body(string $attrs="", array $args=[])
 */
trait _FHtmlCallTrait
{
    /**
     * @param $name
     * @param $arguments
     *
     * @return FHtml
     */
    public function __call($name, $arguments) : self
    {
        if (count ($arguments) === 0) {
            // Variant: ->div()
            return $this->elem("{$name}");
        } else if (is_array($arguments[0])) {
            // Variant: ->div(["@class=?", $className])
            $args = $arguments[0];
            $attrs = array_shift($args);
            return $this->elem("{$name} {$attrs}", ...$args);
        } else {
            // Variant: ->div("@class=?", $classname)
            $attrs = array_shift($arguments);
            return $this->elem("{$name} {$attrs}", ...$arguments);
        }
    }
}
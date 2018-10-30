<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 19.04.18
 * Time: 14:24
 */

namespace Phore\Html\Fhtml;


use Phore\Html\Elements\RawHtmlNode;

trait _FHtmlExtraTrait
{

    /**
     * Generate <select> options on the Fly
     *
     * <example>
     * fhtml("select @name=country1")->options(["at"=>"Austria", "de" => "Germany", "us" => "USA"], $_POST["country1"]);
     * </example>
     *
     * @param array $options
     * @param string|null $selected
     * @return FHtml
     */
    public function options(array $options, string $selected=null) : self {
        foreach ($options as $key => $value) {
            if ($selected == $key)
                $this->elem("option @value=? @selected=selected", $key)->text($value)->end();
            else
                $this->elem("option @value=?", $key);
        }
        return $this;
    }

    public static function Markdown(string $content) : RawHtmlNode
    {
        if ( ! class_exists("\ParsedownExtra"))
            throw new \InvalidArgumentException("Class ParsedownExtra not found. Is optional package erusev/parsedown-extra installed?");
        $parser = new \ParsedownExtra();
        return new RawHtmlNode($parser->text($content));
    }


    public static function MarkdownFile(string $filename) : RawHtmlNode
    {
        if ( ! $text = file_get_contents($filename))
            throw new \InvalidArgumentException("Cannot read '$filename'.");
        return self::markdown($text);
    }
}

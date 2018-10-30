<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 18.08.16
     * Time: 11:44
     */

    namespace Phore\Html\Fhtml;

    use Phore\Html\Elements\DocumentNode;
    use Phore\Html\Elements\HtmlContainerElement;
    use Phore\Html\Elements\HtmlElement;
    use Phore\Html\Elements\HtmlElementAttachable;
    use Phore\Html\Elements\HtmlElementNode;

    /**
     * Class FHtml
     *
     * @package Html5\FHtml
     *
     */
    class FHtml implements HtmlElementNode, \ArrayAccess
    {
        use _FHtmlExtraTrait, _FHtmlTemplateTrait;

        /**
         * @var DocumentNode
         */
        protected $documentNode;

        /**
         * @var HtmlContainerElement
         */
        protected $curNode;

        /**
         * @var null
         */
        protected $parent = null;

        protected $emptyTags = ["meta"=>true, "img"=>true, "br"=>true, "hr"=>true, "input"=>true, "link"=>true];

        public function __construct(array $template=null)
        {
            $this->documentNode = new DocumentNode();
            $this->curNode = $this->documentNode;

            if ($template !== null)
                $this->tpl($template);
        }


        protected function _parseElem (string $elemDef, $arrayArgs=[]) : array
        {
            $arr = explode("@", $elemDef);
            $tagName = trim(array_shift($arr));
            if ($tagName === "")
                $tagName = "div";


            $attrs = [];
            $qmIndex = 0;
            foreach ($arr as $attdef) {
                if ($attdef === "")
                    continue;
                $arr = explode("=", $attdef, 2);
                if (count($arr) == 1) {
                    // Shortcut for @class=classname: @classname
                    $val = $arr[0];
                    $key = "class";
                } else {
                    // @class=classname
                    $key = $arr[0];
                    $val = $arr[1];
                }


                if ( ! isset ($val)) {
                    $attrs[trim ($key)] = "";
                    continue;
                }

                $val = trim ($val);
                if (isset ($arrayArgs)) {
                    if ($val == "?" && isset ($arrayArgs[$qmIndex])) {
                        $val = $arrayArgs[$qmIndex];
                        $qmIndex++;
                    } else if (preg_match ("|^\:([a-zA-Z0-9_\-\+]+)|", $val, $matches)) {
                        if (is_array($arrayArgs)) {
                            if ( ! isset ($arrayArgs[$matches[1]])) {
                                throw new \InvalidArgumentException("Cannot find parameter ':{$matches[1]}' in "
                                    .print_r($arrayArgs, true));
                            }
                            $val = $arrayArgs[$matches[1]];
                        } else if (is_object($arrayArgs)) {
                            if ( ! isset ($arrayArgs->{$matches[1]}))
                                throw new \InvalidArgumentException("Cannot find paramter ':{$matches[1]}' in " . print_r($arrayArgs, true));
                            $val = $arrayArgs->{$matches[1]};
                        } else {
                            throw new \InvalidArgumentException("Parameter 2 must be array,object or null");
                        }
                    }
                }
                if ( ! isset ($attrs[trim($key)])) {
                    $attrs[trim($key)] = $val;
                } else {
                    $attrs[trim($key)] .= " " . $val;
                }
            }
            return [$tagName, $attrs];
        }



        /**
         * Define the sub-Element of the current node
         *
         * Example
         *
         * $e->elem("div @class = a b c @name = some Name")
         * @param string $elemDef
         * @param array $arrayArgs
         * @return FHtml
         */
        public function elem(string $elemDef, $arrayArgs=[]) : self
        {
            if (strpos($elemDef, ">") !== false) {
                // Multi-Element
                $curElem = $this;
                foreach (explode(">", $elemDef) as $curDef) {
                    $curElem = $curElem->elem(trim ($curDef));
                }
                return $curElem;
            }

            [$tagName, $attrs] = $this->_parseElem($elemDef, $arrayArgs);

            if (isset ($this->emptyTags[$tagName])) {
                $newNode = new HtmlElement($tagName, $attrs);
            } else {
                $newNode = new HtmlContainerElement($tagName, $attrs);
            }
            $this->curNode->add($newNode);
            return $this->cloneit($newNode);
        }


        public function content($child) : self
        {
            if ($child === null)
                return $this;
            if ($child instanceof HtmlElementAttachable)
                $child = $child->getHtmlElementNode();

            if ( ! $child instanceof HtmlElementNode) {
                $child = (string)$child;
                $child = self::Text($child);
            }
            $this->curNode->add($child);
            return $this;
        }

        private function cloneit ($curNode) : FHtml
        {
            $new = new self();
            $new->curNode = $curNode;
            $new->documentNode = $this->documentNode;
            return $new;
        }

        public function end() : self
        {
            if ($this->curNode->getParent() === $this->curNode)
                throw new \InvalidArgumentException("end(): Node is document node.");
            return $this->cloneit($this->curNode->getParent());
        }

        public function root() : self {
            return $this->cloneit($this->documentNode);
        }

        public function getDocument() : DocumentNode
        {
            return $this->documentNode;
        }

        public function renderPage() : string
        {
            return "<!doctype html>" . $this->render();
        }

        public function render($indent = "  ", $index = 0): string
        {
            return $this->documentNode->render($indent, $index);
        }

        public function __toString()
        {
            return $this->render();
        }

        /**
         * Remove all child elements
         *
         * @return FHtml
         */
        public function empty() : self
        {
            if ($this->curNode instanceof HtmlContainerElement)
                $this->curNode->clearChildren();
            return $this;
        }


        public function query($query) : FHtmlQueryResult
        {
            $selectType = substr($query, 0, 1);
            if ($selectType === "#") {
                $result = $this->documentNode->getRootDocument()->getElementById(substr($query, 1));
                $new = new FHtmlQueryResult(null, [$result]);
                $new->curNode = $result;
                $new->documentNode = $this->documentNode;
                return $new;
            }

            $result = [];
            $this->curNode->walkChildren(function (HtmlElementNode $node) use (&$result, $query) {
                if ( ! $node instanceof HtmlElement)
                    return;
                if ($node->getTag() === $query)
                    $result[] = $node;
            });
            $new = new FHtmlQueryResult(null, [$result]);
            $new->curNode = $result;
            $new->documentNode = $this->documentNode;
            return $new;
        }


        public function alter(string $elemDef, $arrayArgs=[]) : self
        {
            [$tagName, $attrs] = $this->_parseElem($elemDef, $arrayArgs);

            //print_r ($attrs);
            foreach ($attrs as $key => $value) {
                if ($key === "class")
                    continue;
                switch (substr($key, 0, 1)) {
                    case "+":
                        $this->curNode->setAttrib(substr($key, 1), $value);
                        break;
                    case "-":
                        $this->curNode->remAttrib(substr($key, 1));
                        break;
                    default:
                        $this->curNode->setAttrib($key, $value);
                }
            }

            if (isset ($attrs["class"])) {
                foreach (explode(" ", $attrs["class"]) as $cssClass) {
                    switch (substr($cssClass, 0, 1)) {
                        case "+":
                        $this->curNode->addCssClass(substr($cssClass, 1));
                        break;
                    case "-":
                        $this->curNode->remCssClass(substr($cssClass, 1));
                        break;
                    default:
                        $this->curNode->addCssClass($cssClass);
                    }
                }
            }

            return $this;
        }


        public function macro(FHtmlMacro $macro) : self
        {
            return $macro->onAttach($this);
        }


        public function _setParent(HtmlContainerElement $parent)
        {
            $this->parent = $parent;
        }

        public function getParent(): HtmlContainerElement
        {
            return $this->parent;
        }
        /**
         * Whether a offset exists
         * @link http://php.net/manual/en/arrayaccess.offsetexists.php
         * @param mixed $offset <p>
         * An offset to check for.
         * </p>
         * @return boolean true on success or false on failure.
         * </p>
         * <p>
         * The return value will be casted to boolean if non-boolean was returned.
         * @since 5.0.0
         */
        public function offsetExists($offset)
        {
            throw new \InvalidArgumentException("Not implemented yet");
        }

        /**
         * Offset to retrieve
         * @link http://php.net/manual/en/arrayaccess.offsetget.php
         * @param mixed $offset <p>
         * The offset to retrieve.
         * </p>
         * @return mixed Can return all value types.
         * @since 5.0.0
         */
        public function offsetGet($offset)
        {
            throw new \InvalidArgumentException("Not implemented yet");
        }

        /**
         * Offset to set
         * @link http://php.net/manual/en/arrayaccess.offsetset.php
         * @param mixed $offset <p>
         * The offset to assign the value to.
         * </p>
         * @param mixed $value <p>
         * The value to set.
         * </p>
         * @return void
         * @since 5.0.0
         */
        public function offsetSet($offset, $value)
        {
            if ($offset !== null)
                throw new \InvalidArgumentException("Altering using Array access not impemented yet");
            $this->content(fhtml()->tpl($value));
        }

        /**
         * Offset to unset
         * @link http://php.net/manual/en/arrayaccess.offsetunset.php
         * @param mixed $offset <p>
         * The offset to unset.
         * </p>
         * @return void
         * @since 5.0.0
         */
        public function offsetUnset($offset)
        {
            throw new \InvalidArgumentException("Not implemented yet");
        }


    }

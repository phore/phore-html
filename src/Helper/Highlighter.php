<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.04.18
 * Time: 15:34
 */

namespace Phore\Html\Helper;


class Highlighter
{

    private $file;
    private $startNo;

    public function __construct()
    {
        $this->start_recording();
    }

    
    public function start_recording()
    {
        $backtrace = debug_backtrace()[0];
        $this->file = $backtrace["file"];
        $this->startNo = $backtrace["line"];
    }
    
    
    public function end_recording() : string 
    {
        $backtrace = debug_backtrace()[0];
        $endLine = $backtrace["line"]-1;

        $data = file($this->file);

        $ret = [];
        for ($i=$this->startNo; $i<$endLine; $i++)
            $ret[] = $data[$i];
        return "\n" . implode("", $ret);
    }
    

    public function getCode() : string
    {
        return $this->end_recording();
    }

}
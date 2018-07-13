<?php

namespace Test;

require __DIR__ . "/../vendor/autoload.php";


$fhtml = fhtml("div @class=header some class @id=abcd")->content("Hello World");

$fhtml->alter("@class=-some +other"); // Remove class some - add class other

echo $fhtml->render();


/*

<div class="header some class" id="abcd">
    Hello World
</div>

 */
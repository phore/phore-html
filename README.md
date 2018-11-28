# Phore HTML Toolkit

- Fluent API for creating HTML Elements
- Create, alter, render

## Basic example

```php
// Create a div element:
$elem = fhtml("div @id=main @class=website");

// Append a <div id=content> to the 
$elem[] = [
    "div @id=content" => "Some Content"
];

// Append paragraph to content div: 
$elem["?#content"][] = ["p" => "Some escaped content"];

// Render full page including html-header
echo $elem->renderPage(); 
```
will output:

```html
<div id="main" class="website">
    <div id="content">
        Some Content
        <p>Some escaped content</p>
    </div>
</div>
```


## Creating html structures



```
$doc = fhtml("div @id=name2 @class=bordered");
$doc->alter();
```


## Rendering Templates



## Appending to Templates

Use the array append syntax (`$template[] =`) to append elements to 
an existing element:

```
$t = fhtml();

$t[] = ["@h1" => "Hello World"];

```

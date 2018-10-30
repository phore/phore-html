# Phore HTML Toolkit

- Fluent API for creating HTML Elements

## Basic example

```
$elem = fhtml("div @class=someClass @id=abc");
$elem->elem("a @href=:url", ["http://some.url"])->content("Click me");
$elem->render(); // Render partial
$elem->renderPage(); // Render full page including html-header
```

## Altering Elements

```
$doc = fhtml("div @id=name2 @class=bordered");
$doc->alter();
```


## Rendering Templates

```
$doc->tpl([
    "div @class=content" => [
        ["p" => "Hello World"],
        ["p" => "And hello world 2"]
    ]
]);
```

## Appending to Templates

Use the array append syntax (`$template[] =`) to append elements to 
an existing element:

```
$t = fhtml();

$t[] = ["@h1" => "Hello World"];

```

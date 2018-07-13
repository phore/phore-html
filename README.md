# Phore HTML Toolkit

- Fluent API for creating HTML Elements

## Basic example

```
$elem = fhtml("div @class=someClass @id=abc");
$elem->elem("a @href=:url", ["http://some.url"])->content("Click me");
```



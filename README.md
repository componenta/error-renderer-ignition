# Componenta Error Renderer Ignition

Spatie Ignition renderer integration for `componenta/error-handler`. It adapts Ignition error pages to `ErrorRendererInterface`.

## Installation

```bash
composer require componenta/error-renderer-ignition
```

## Main API

```php
use Componenta\Error\Renderer\IgnitionRenderer;

$renderer = new IgnitionRenderer();
$error = (new \Componenta\Error\ErrorOccurrenceFactory())->create($exception);
$result = $renderer->render($error, $context);
$html = (string) $result;
$contentType = $result->contentType;
```

The renderer is intended for detailed development error output.

## Boundary

This package only provides `IgnitionRenderer`. Application error handling, listeners, response emission, and safe production pages are outside this package.

`render()` returns the core `RenderedError` value, with `content`, `contentType`, and explicit string conversion. Requires Error Handler 2.

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
$html = $renderer->render($exception, $context);
```

The renderer is intended for detailed development error output.

## Boundary

This package only provides `IgnitionRenderer`. Application error handling, listeners, response emission, and safe production pages are outside this package.

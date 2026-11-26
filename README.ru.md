# Componenta Error Renderer Ignition

Интеграция рендерера Spatie Ignition для `componenta/error-handler`. Пакет адаптирует страницы ошибок Ignition к `ErrorRendererInterface`.

## Установка

```bash
composer require componenta/error-renderer-ignition
```

## Основной API

```php
use Componenta\Error\Renderer\IgnitionRenderer;

$renderer = new IgnitionRenderer();
$error = (new \Componenta\Error\ErrorOccurrenceFactory())->create($exception);
$result = $renderer->render($error, $context);
$html = (string) $result;
$contentType = $result->contentType;
```

Рендерер предназначен для подробного вывода ошибок в разработке.

## Граница пакета

Пакет предоставляет только `IgnitionRenderer`. Обработка ошибок приложения, слушатели, отправка ответа и безопасные страницы для боевого окружения находятся вне этого пакета.

Метод `render()` возвращает объект `RenderedError` из ядра с полями `content`, `contentType` и преобразованием в строку. Требуется Error Handler 2.

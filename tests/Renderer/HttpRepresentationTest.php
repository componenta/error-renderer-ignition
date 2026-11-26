<?php

declare(strict_types=1);

namespace Componenta\Error\Renderer\Ignition\Tests\Renderer;

use Componenta\Error\ErrorOccurrence;
use Componenta\Error\Context\HttpContext;
use Componenta\Error\Renderer\IgnitionRenderer;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class HttpRepresentationTest extends TestCase
{
    public function testRenderingPreservesOutputBufferDepth(): void
    {
        $level = ob_get_level();
        $result = (new IgnitionRenderer())->render(
            new ErrorOccurrence(new RuntimeException('ignition test'), 'ERR-test'),
            new HttpContext(new ServerRequest('GET', '/')),
        );
        self::assertSame($level, ob_get_level());
        self::assertSame('text/html; charset=utf-8', $result->contentType);
        self::assertNotEmpty($result->content);
        self::assertSame($result->content, (string) $result);
    }
}

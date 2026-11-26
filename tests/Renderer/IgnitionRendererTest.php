<?php

declare(strict_types=1);

namespace Componenta\Error\Renderer\Ignition\Tests\Renderer;

use Componenta\Error\ErrorOccurrence;
use Componenta\Error\Context\CliContext;
use Componenta\Error\Renderer\IgnitionRenderer;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Spatie\Ignition\Ignition;

#[TestDox('IgnitionRenderer')]
final class IgnitionRendererTest extends TestCase
{
    public function testRenderReturnsHtmlOutputWhenIgnitionIsInstalled(): void
    {
        if (!class_exists(Ignition::class)) {
            self::markTestSkipped('spatie/ignition is not installed in the root test environment.');
        }

        $renderer = new IgnitionRenderer();
        $exception = new RuntimeException('Ignition renderer test');

        $output = $renderer->render(new ErrorOccurrence($exception, 'ERR-test'), CliContext::fromArgv());
        self::assertSame('text/html; charset=utf-8', $output->contentType);
        self::assertSame($output->content, (string) $output);

        self::assertNotEmpty($output->content);
    }
}

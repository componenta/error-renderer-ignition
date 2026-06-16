<?php

declare(strict_types=1);

namespace Componenta\Error\Renderer;

use Throwable;
use Spatie\Ignition\Ignition;
use Componenta\Error\ErrorContextInterface;
use Componenta\Error\Renderer\ErrorRendererInterface;

/**
 * Ignition-based error renderer
 *
 * Renders exceptions using Spatie's Ignition with beautiful error pages,
 * AI-powered solution suggestions, and stack trace visualization.
 */
class IgnitionRenderer implements ErrorRendererInterface
{
    private(set) Ignition $ignition;

    /**
     * Create Ignition renderer
     *
     * @param string|null $editor IDE editor for file links (phpstorm, vscode, sublime, atom, etc.)
     * @param string|null $theme Color theme (light, dark, auto)
     * @param array<class-string> $solutionProviders Solution provider classes to add
     */
    public function __construct(
        ?string $editor = null,
        ?string $theme = 'auto',
        array $solutionProviders = [],
    ) {
        $this->ignition = Ignition::make()
            ->applicationPath(getcwd() ?: '');

        if ($editor !== null) {
            $this->ignition->setEditor($editor);
        }

        if ($theme !== null) {
            $this->ignition->setTheme($theme);
        }

        if ($solutionProviders !== []) {
            $this->ignition->addSolutionProviders($solutionProviders);
        }
    }

    /**
     * Render exception as HTML
     */
    public function render(Throwable $exception, ErrorContextInterface $context): string
    {
        ob_start();
        $this->ignition->handleException($exception);
        return ob_get_clean() ?: '';
    }

    /**
     * Check if renderer supports the exception
     */
    public function supports(Throwable $exception, ErrorContextInterface $context): bool
    {
        return true;
    }
}
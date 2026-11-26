<?php

declare(strict_types=1);

namespace Componenta\Error\Renderer;

use Componenta\Error\ErrorContextInterface;
use Spatie\Ignition\Ignition;
use RuntimeException;
use Throwable;

/** Development renderer: rendering alone does not report to Flare. */
final readonly class IgnitionRenderer implements ErrorRendererInterface
{
    public function __construct(
        private ?string $editor = null,
        private ?string $theme = 'auto',
        private array $solutionProviders = [],
    ) {
    }

    public function render(Throwable $exception, ErrorContextInterface $context): RenderedError
    {
        $ignition = Ignition::make()->applicationPath(getcwd() ?: '');
        if ($this->editor !== null) {
            $ignition->setEditor($this->editor);
        }
        if ($this->theme !== null) {
            $ignition->setTheme($this->theme);
        }
        if ($this->solutionProviders !== []) {
            $ignition->addSolutionProviders($this->solutionProviders);
        }

        $level = ob_get_level();
        ob_start();
        try {
            $ignition->renderException($exception);
            if (ob_get_level() !== $level + 1) {
                throw new RuntimeException('Unexpected Ignition output buffer state.');
            }
            return new RenderedError(ob_get_contents() ?: '', 'text/html; charset=utf-8');
        } finally {
            while (ob_get_level() > $level) {
                $before = ob_get_level();
                if (!@ob_end_clean() || ob_get_level() === $before) {
                    break;
                }
            }
        }
    }

    public function supports(Throwable $exception, ErrorContextInterface $context): bool
    {
        return true;
    }
}

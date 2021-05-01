<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests;

use Closure;
use Orchestra\Testbench\Dusk\Options as DuskOptions;

trait DuskElements
{
    /**
     * We don't want to deal with screenshots or console logs.
     */
    protected function storeConsoleLogsFor($browsers)
    {
    }

    protected function captureFailuresFor($browsers)
    {
    }

    public function browse(Closure $callback)
    {
        parent::browse(function (...$browsers) use ($callback) {
            try {
                $callback(...$browsers);
            } catch (Exception $e) {
                if (DuskOptions::hasUI()) {
                    $this->breakIntoATinkerShell($browsers, $e);
                }

                throw $e;
            } catch (Throwable $e) {
                if (DuskOptions::hasUI()) {
                    $this->breakIntoATinkerShell($browsers, $e);
                }

                throw $e;
            }
        });
    }

    public function breakIntoATinkerShell($browsers, $e)
    {
        $sh = new Shell();

        $sh->add(new DuskCommand($this, $e));

        $sh->setScopeVariables([
            'browsers' => $browsers,
        ]);

        $sh->addInput('dusk');

        $sh->setBoundObject($this);

        $sh->run();

        return $sh->getScopeVariables(false);
    }
}

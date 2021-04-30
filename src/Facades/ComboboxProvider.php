<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Facades;

use Daguilarm\LivewireCombobox\Components\Combobox;
use Illuminate\Support\ServiceProvider;

final class ComboboxProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton('Combobox', static function () {
            return new Combobox();
        });
    }
}

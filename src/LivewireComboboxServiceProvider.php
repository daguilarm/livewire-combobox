<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class LivewireComboboxServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-combobox')
            ->hasViews();
    }

    public function bootingPackage(): void
    {
        // Blade directives
        Blade::directive('LivewireComboboxCss', static function ($expression) {
            $file = file_get_contents(__DIR__.'/../resources/css/combobox.min.css');

            return sprintf('<style>%s</style>', trim($file));
        });
    }
}

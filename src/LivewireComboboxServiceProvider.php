<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox;

use Daguilarm\LivewireCombobox\Facades\Combobox;
use Daguilarm\LivewireCombobox\Facades\ComboboxProvider;
use Illuminate\Foundation\AliasLoader;
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

    public function registeringPackage(): void
    {
        $this->app->register(ComboboxProvider::class);
        AliasLoader::getInstance()->alias('Combobox', Combobox::class);
    }
}

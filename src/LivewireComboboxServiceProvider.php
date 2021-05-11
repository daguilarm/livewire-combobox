<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox;

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
}

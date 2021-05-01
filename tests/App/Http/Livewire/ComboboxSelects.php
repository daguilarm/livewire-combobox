<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Http\Livewire;

use Daguilarm\LivewireCombobox\Components\ComboboxLivewireComponent;
use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Contracts\Combobox;
use Daguilarm\LivewireCombobox\Tests\App\Models\Car;
use Daguilarm\LivewireCombobox\Tests\App\Models\Option;

class ComboboxSelects extends ComboboxLivewireComponent implements Combobox
{
    public function elements(): array
    {
        return [
            // Testing basic attributes
            Select::make('Cars', Car::class)
                ->uriKey('key-for-car')
                ->options([1 => 'one', 2 => 'two', 3 => 'three']),
            // Testing dependOn attributes
            Select::make('Options 1', Option::class)
                ->uriKey('key-for-option-1')
                ->dependOn('key-for-car')
                ->foreignKey('cars_id'),
        ];
    }
}

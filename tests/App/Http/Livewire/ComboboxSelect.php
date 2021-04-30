<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Http\Livewire;

use Daguilarm\LivewireCombobox\Components\ComboboxLivewireComponent;
use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Contracts\Combobox;
use Daguilarm\LivewireCombobox\Tests\App\Models\Car;
use Daguilarm\LivewireCombobox\Tests\App\Models\Option;

class ComboboxSelect extends ComboboxLivewireComponent implements Combobox
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
                ->optionsEmpty()
                ->dependOn('key-for-car')
                ->foreignKey('cars_id'),
            // Testing foreignKey as value in dependOn
            Select::make('Options 2', Option::class)
                ->uriKey('key-for-option-2')
                ->optionsEmpty()
                ->dependOn('key-for-car', 'cars_id'),
            // Testing options with callable
            Select::make('Cars callable', Car::class)
                ->uriKey('key-for-car-callable')
                ->dependOn('key-for-car', 'cars_id')
                ->options(function($model) {
                    return $model
                        ->pluck('id', 'name')
                        ->toArray();
                }),
        ];
    }
}

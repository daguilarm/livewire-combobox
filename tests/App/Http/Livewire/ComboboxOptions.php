<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Http\Livewire;

use Daguilarm\LivewireCombobox\Components\ComboboxLivewireComponent;
use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Contracts\Combobox;
use Daguilarm\LivewireCombobox\Tests\App\Models\Car;
use Daguilarm\LivewireCombobox\Tests\App\Models\Extra;
use Daguilarm\LivewireCombobox\Tests\App\Models\Option;

class ComboboxOptions extends ComboboxLivewireComponent implements Combobox
{
    public function elements(): array
    {
        return [
            // Testing basic attributes
            Select::make('Cars', Car::class)
                ->uriKey('key-for-car')
                ->options(function ($model) {
                    return $model->pluck('name', 'id')->toArray();
                })
                ->class(
                    container: 'bg-green-500',
                    field: 'text-green-600',
                    label: 'text-white'
                ),
            // Testing dependOn attributes
            Select::make('Options for cars')
                ->uriKey('key-for-options')
                ->model(Option::class)
                ->dependOn('key-for-car')
                ->foreignKey('car_id')
                ->selectRows('id', 'option'),
            Select::make('Extras for cars', Extra::class)
                ->firstRemoved()
                ->hideOnEmpty()
                ->uriKey('key-for-extras')
                ->dependOn('key-for-options')
                ->foreignKey('option_id')
                ->selectRows('id', 'extra'),
        ];
    }
}

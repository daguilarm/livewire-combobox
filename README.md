# A dynamic select for Laravel Livewire

![Package Logo](https://banners.beyondco.de/A%20Combobox%20for%20Laravel%20Livewire.png?theme=light&packageManager=composer+require&packageName=daguilarm%2Flivewire-combobox&pattern=architect&style=style_1&description=An+infinite+dynamic+selects.&md=1&showWatermark=1&fontSize=100px&images=selector)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/daguilarm/livewire-combobox.svg?style=flat-square)](https://packagist.org/packages/daguilarm/livewire-combobox)
[![StyleCI](https://styleci.io/repos/363116482/shield?style=plastic)](https://github.styleci.io/repos/363116482)
![GitHub last commit](https://img.shields.io/github/last-commit/daguilarm/livewire-combobox)
<!-- [![Total Downloads](https://img.shields.io/packagist/dt/daguilarm/belich-tables.svg?style=flat-square)](https://packagist.org/packages/daguilarm/belich-tables) -->

## Requirements

This package need at least:

- PHP ^8.0
- Laravel ^8.0
- Laravel Livewire ^2.0
- AlpineJS ^2.0
- TailwindCSS ^2.0

## Installation

You can install the package via composer:

    composer require daguilarm/livewire-combobox

## Documentation

The first thing you have to do is create a component in your folder **Livewire**. Below you can see an example using three selects:

```php 
<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Car;
use App\Models\Extra;
use App\Models\Option;
use Daguilarm\LivewireCombobox\Components\ComboboxLivewireComponent;
use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Contracts\Combobox;

class ComboboxCars extends ComboboxLivewireComponent implements Combobox
{
    public function elements(): array
    {
        return [
            Select::make('Cars', Car::class)
                ->uriKey('key-for-car')
                ->options(function($model) {
                    return $model
                        ->pluck('id', 'name')
                        ->toArray();
                }),
            Select::make('Options for cars', Option::class)
                ->uriKey('key-for-options')
                ->dependOn('key-for-car')
                ->foreignKey('car_id')
                ->selectRows('id', 'option'),
            Select::make('Extras for cars', Extra::class)
                ->firstRemove()
                ->uriKey('key-for-extras')
                ->dependOn('key-for-options')
                ->foreignKey('option_id')
                ->selectRows('id', 'extra'),
        ];
    }
}
```

The **package** supports infinite dependent elements. The method `elements()` should return an array with all the elements. 

Let's see how the class works `Select::class` and its methods:

### make()

The method `make()`, has the following structure:

```php
Select::make(string $label, ?string $model = null);
```

As it can be seen, the attribute `$model` is optional in the `make()` method, and it can be added using the method `model()`:

```php
Select::make('My label')->model(User::class);
```

    Defining the model is mandatory, but it can be done in the two ways described.

### uriKey()

This method is mandatory, it is used to define a unique key for the element.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email damian.aguilarm@gmail.com instead of using the issue tracker.

## Credits

- [Damián Aguilar](https://github.com/daguilarm)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

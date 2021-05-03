![Package Logo](https://banners.beyondco.de/A%20Combobox%20for%20Laravel%20Livewire.png?theme=light&packageManager=composer+require&packageName=daguilarm%2Flivewire-combobox&pattern=architect&style=style_1&description=An+infinite+dynamic+selects.&md=1&showWatermark=1&fontSize=100px&images=selector)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/daguilarm/livewire-combobox.svg?style=flat-square)](https://packagist.org/packages/daguilarm/livewire-combobox)
[![StyleCI](https://styleci.io/repos/363116482/shield?style=plastic)](https://github.styleci.io/repos/363116482)
![GitHub last commit](https://img.shields.io/github/last-commit/daguilarm/livewire-combobox)
[![Total Downloads](https://img.shields.io/packagist/dt/daguilarm/livewire-combobox.svg?style=flat-square)](https://packagist.org/packages/daguilarm/livewire-combobox)

# Livewire Combobox: A dynamic selects for Laravel Livewire

A Laravel Livewire multiple selects depending on each other values, with infinite levels of dependency and totally configurable.

## Requirements

This package need at least:

- PHP ^8.0
- Laravel ^8.0
- Laravel Livewire ^2.0
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
                        ->pluck('name', 'id')
                        ->toArray();
                }),
            Select::make('Options for cars', Option::class)
                ->uriKey('key-for-options')
                ->dependOn('key-for-car')
                ->foreignKey('car_id')
                ->selectRows('id', 'option'),
            Select::make('Extras for cars')
                ->model(Extra::class)
                ->firstRemoved()
                ->hideOnEmpty()
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

#### make()

The method `make()`, has the following structure:

```php
Select::make(string $label, ?string $model = null);
```

#### model()

As it can be seen, the attribute `$model` is optional in the `make()` method, and it can be added using the method `model()`:

```php
Select::make('My label')->model(User::class);
```

> :warning: Defining the model is mandatory, but it can be done in the two ways described.

#### uriKey()

This method is mandatory, it is used to define a unique key for the element.

#### hideOnEmpty()

Dependent children are removed if they are empty, instead of showing an empty field.

## Child elements

These elements have their own methods, apart from those described above. 
These child elements do not need the method `options()`, although it can be added if desired. The child specific methods are described below:

### dependOn()

With this method we define the parent element on which our child element depends. We must use the `uriKey` from the parent element. The basic structure of the method is:

```php
dependOn(?string $parentUriKey = null, ?string $foreignKey = null)
```

As can be seen, it admits a second value which is the *foreing key* that links the two models: **Parent** and **Child**. This second field can also be added in two ways:

```php 
// Option 1
Select::make(...)
    ->dependOn('key-for-options', 'option_id');

// Option 2
Select::make(...)
    ->dependOn('key-for-options')
    ->foreignKey('option_id');
```

### selectRows()

It is used to select the fields from the table that we want to load in the child element.

## Field Types 

At the moment, the package support the folowing field types:

### Select field

Estos campos disponen de los siguientes métodos:

#### options()

It is used to add the values ​​that will be shown in the element **select**. We can directly add a `array` with the values, or define a `callback`. The two values ​​returned by the `array`: key and value, are shown as follows in the **Blade** template:

```php 
// The array
[
    1 => 'Car',
    2 => 'Bike',
    3 => 'Plane'
]

//Will be render as 
<option value="1">Car</option>
<option value="2">Bike</option>
<option value="3">Plane</option>
```

Therefore, in the component example (will be reverse):

```php 
// The array
Select::make(...)
    ->options(function($model) {
        return $model
            ->pluck('name', 'id')
            ->toArray();
    })

//Will be render as 
<option value="id">name</option>
```

#### firstRemoved()

By default, each item will show a select field with an empty `option` element:

```html 
// Element
<select>
    <option value=""></option>
    ...
</select>
```

If we want to remove it, we can add the method `firstRemoved()`.

### Search field 

comming soon... 

## Customize the display of elements

The package uses **TailwindCSS** so the styles must be based on it. The structure of the elements is as follows:

```html 
<!-- Main container -->
<div id="container">

    <!-- Element 1 -->
    <div id="element-container-1">
        <label id="label-1"></label>
        <select id="select-1"></select>
    </div>

    <!-- Element 2 -->
    <div id="element-container-2">
        <label id="label-2"></label>
        <select id="select-2"></select>
    </div>

</div>
```

We can modify the styles of the *Main Container* from the component that we created at the beginning of the documentation, using the `$comboboxContainerClass`:

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
    public string $comboboxContainerClass = 'flex p-2 m-2 bg-gray-100';

    public function elements(): array
    {
        return [];
    }
}
```

To modify an element, we will have to do it directly from each of them, using the method `class()`:

```php 
Select::make('Cars', Car::class)
    ->uriKey('key-for-car')
    ->options(function($model) {
        return $model
            ->pluck('id', 'name')
            ->toArray();
    })
    ->class('p-4', 'text-green-600', 'text-lg'),
```

We can use the new functionality of **php 8** to modify only those parts that interest us, or we can use the method directly:

```php 
// Method 1
Select::make(...)
    ->class(
        container: 'p-4',
        field: 'text-lg',
    ),

// Method 2
Select::make(...)
    ->class('p-4', null, 'text-lg'),
```

The order of the parameters is:

```php 
class(?string $container = null, ?string $label = null, ?string $field = null)
```

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

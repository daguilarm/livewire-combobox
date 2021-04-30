<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Facades;

use Illuminate\Support\Facades\Facade;

final class Combobox extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Combobox';
    }
}

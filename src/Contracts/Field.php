<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Contracts;

use Daguilarm\LivewireCombobox\Components\FieldComponent;

interface Field
{
    /**
     * The base method.
     */
    public static function make(string $label, string $model): FieldComponent;
}

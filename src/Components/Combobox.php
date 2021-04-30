<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

/**
 * Class Combobox.
 */
final class Combobox
{
    /**
     * Get value from element.
     */
    public function value(object | array $element, int | bool | float | string | null $value): array | bool | int | float | string | null
    {
        if (is_array($element)) {
            return $element[$value] ?? null;
        }

        if (is_object($element)) {
            return $element?->{$value} ?? null;
        }

        return null;
    }
}

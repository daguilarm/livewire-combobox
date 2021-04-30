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
     *
     * @param int | bool | float | string | null $value
     *
     * @return array | bool | int | float | string | null
     */
    public function value(object | array $element, $value)
    {
        if (is_array($element)) {
            return isset($element[$value]) ? $element[$value] : null;
        }

        if (is_object($element)) {
            return $element?->{$value} ?? null;
        }

        return null;
    }
}

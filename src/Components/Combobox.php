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
    public function value(object | array $element, string $key): array | bool | int | float | string | null
    {
        if (is_array($element)) {
            return $element[$key] ?? null;
        }

        if (is_object($element)) {
            return $element?->{$key} ?? null;
        }

        return null;
    }

    /**
     * Get total items from an element.
     */
    public function count(object | array $element, string $key): int
    {
        if (is_array($element)) {
            return (int) count(array_filter($element[$key]));
        }

        if (is_object($element)) {
            return (int) collect($element?->{$key})->filter()->count();
        }

        return 0;
    }
}

<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components\Combobox;

/**
 * Class Select.
 */
trait DependOnChild
{
    /**
     * Determines if the element has a parent.
     *
     * @param array<int | float | string | null> $element
     */
    private function childElementHasParent(array $element, string $uriKey): bool
    {
        // Check if the child element has a parent element
        return $element['parentUriKey'] === $uriKey;
    }

    /**
     * Get child element from parent.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function getChildElementFromParent(array $element, string $uriKey): array
    {
        // Get the parent element value
        $value = $this->comboboxValues[$uriKey];

        // Set the default value
        $element['defaultValue'] = $value;

        // Get the options
        $element['options'] = app($element['model'])
            ->where($element['foreignKey'], $value)
            ->pluck($element['childTableRowLabel'], $element['childTableRowValue'])
            ->toArray();

        // Clear childs. Set the max range for a child
        $this->elementPositionDelete = $this->elementPosition + $this->maxRangeForWildElements;

        return $element;
    }

    /**
     * Resolve and set the child element.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function resolveChildElement(array $element): array
    {
        // Set element position if array
        if (is_array($element)) {
            $element['position'] = $this->elementPosition;
        }

        // Set element position if object (for testing)
        if (is_object($element)) {
            $element->position = $this->elementPosition;
        }

        $this->elementPosition++;

        return $element;
    }
}

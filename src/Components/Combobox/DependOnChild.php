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

        // Get the options if there is no array with values
        // And type!!!!
        // if (! $element['options']) {
        //     $element['options'] = app($element['model'])
        //         ->where($element['foreignKey'], $value)
        //         ->pluck($element['childTableRowValue'], $element['childTableRowLabel'])
        //         ->toArray();
        // }

        $element['options'] = app($element['model'])
            ->where($element['foreignKey'], $value)
            ->pluck($element['childTableRowValue'], $element['childTableRowLabel'])
            ->toArray();

        // Clear childs. Set the max range for a child
        $this->elementPositionDelete = $this->elementPosition + $this->maxRangeForChildElements;

        return $element;
    }

    /**
     * Update the child element if it has a parent element.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function updateChildElementIfHasParent(array $element, string $uriKey): array
    {
        if ($this->childElementHasParent($element, $uriKey)) {
            // Get child element from parent
            $element = $this->getChildElementFromParent($element, $uriKey);

            // Clear childs if they are out of range
            $this->elementPositionDelete = $this->elementPosition + 2;
        }

        return $element;
    }

    /**
     * Resolve the parent element position for the childs.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function resolvePositionForChildElements(array $element): array
    {
        // Add a new level for the elements
        $this->elementPosition++;

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

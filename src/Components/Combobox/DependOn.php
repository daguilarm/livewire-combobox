<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components\Combobox;

use Daguilarm\LivewireCombobox\Facades\Combobox;

/**
 * Class Select.
 */
trait DependOn
{
    public int $elementPosition = 0;
    public int $elementPositionDelete = 0;
    public int $maxRangeForWildElements = 2;

    /**
     * Resolve all the elements.
     *
     * @return array<int | float | string | null>
     */
    public function resolveElements(string $uriKey): array
    {
        return collect($this->elements)
            ->map(function ($element) use ($uriKey) {
                // Set the parent element
                if (! Combobox::value($element, 'parentUriKey')) {
                    return $this->resolveParentElement($element);
                }

                // Reset the elements out of the delete range
                if ($this->resolveElementPosition()) {
                    return $this->deleteElementsOutOfRange($element);
                }

                // Update childs if has a parent
                if ($this->childElementHasParent($element, $uriKey)) {
                    // Get child element from parent
                    $element = $this->getChildElementFromParent($element, $uriKey);

                    // Clear childs if they are out of range
                    $this->elementPositionDelete = $this->elementPosition + 2;
                }

                return $this->resolveChildElement($element);
            })
            ->filter()
            ->toArray();
    }

    /**
     * Resolve the parent element.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function resolveParentElement(array $element): array
    {
        // Add a new level for the elements
        $this->elementPosition++;

        return $element;
    }

    /**
     * Determines if the current position is within the delete margin.
     */
    private function resolveElementPosition(): bool
    {
        // Determines if the current position is within the range
        $deletePosition = $this->elementPositionDelete > $this->elementPosition;

        // If there is a marge and the current position valid,
        // then the childs out of range must be reset
        return $this->elementPositionDelete > 0 && $deletePosition;
    }

    /**
     * Determines if the current position is within the delete margin.
     *
     * @param array<int | float | string | null> $element
     *
     * @return array<int | float | string | null>
     */
    private function deleteElementsOutOfRange(array $element): array
    {
        // Reset the element options
        $element['options'] = ['' => ''];

        // Restart element position
        $this->elementPositionDelete = 0;

        return $element;
    }

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

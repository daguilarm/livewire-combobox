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
            // Set the parent element
            ->filter(function($element) {
                return ! Combobox::value($element, 'parentUriKey')
                    ? $this->resolveParentElement($element)
                    : $element;
            })
            ->map(function ($element) use ($uriKey) {
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
}

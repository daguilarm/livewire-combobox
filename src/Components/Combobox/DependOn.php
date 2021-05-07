<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components\Combobox;

use Daguilarm\LivewireCombobox\Facades\Combobox;
use Illuminate\Support\Collection;

/**
 * Class Select.
 */
trait DependOn
{
    protected int $elementPosition = 0;
    protected int $elementPositionDelete = 0;
    protected int $maxRangeForChildElements = 2;

    /**
     * Resolve all the elements.
     *
     * @return array<int | float | string | null>
     */
    protected function resolveElements(string $uriKey): array
    {
        // Reset all the elements if parent element is empty
        $this->resetValuesIfParentIsEmpty();

        return $this->getElements()
            ->map(function ($element) use ($uriKey) {
                // Reset all the elements out of range
                if ($this->resolveElementPosition()) {
                    return $this->deleteElementsOutOfRange($element);
                }

                // Update child element if it has a parent
                $element = $this->updateChildElementIfHasParent($element, $uriKey);

                // Resolve the child element
                return $this->resolveChildElement($element);
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get all the elements.
     */
    private function getElements(): Collection
    {
        return collect($this->elements)
            // Get the elements
            ->filter(function ($element) {
                // Parent element
                if (Combobox::value($element, 'parentUriKey')) {
                    return $element;
                }

                // Child element
                return $this->resolvePositionForChildElements($element);
            });
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
     * Reset the all the elements if parent element is empty.
     */
    private function resetValuesIfParentIsEmpty(): void
    {
        // Parent element
        $parent = $this->elements[0]['uriKey'];

        if (! $this->comboboxValues[$parent]) {
            // Reset the values
            $this->comboboxValues = [];
            $this->comboboxValues[$parent] = [];
        }
    }
}

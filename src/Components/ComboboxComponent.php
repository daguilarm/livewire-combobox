<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

use Illuminate\Support\Arr;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Class Combobox Component.
 */
abstract class ComboboxComponent extends Component
{
    /**
     * @var array<string>
     */
    public array $comboboxValues = [];

    /**
     * @var array<Illuminate\Support\Collection>
     */
    protected array $elements = [];

    // Customized variables
    protected string $containerClass;
    protected bool $loading = true;

    // Current element
    protected string $currentUriKey = '';

    /**
     * Listeners.
     *
     * @var array<string>
     */
    protected $listeners = ['dependOn'];

    /**
     * Init constructor.
     *
     * @see  Daguilarm\LivewireCombobox\Components\ComboboxComponent
     */
    public function __construct()
    {
        $this->elements = $this->elements();
    }

    /**
     * Render the view in the blade template.
     */
    public function render(): View
    {
        return view('livewire-combobox::combobox', [
            'config' => [
                'containerClass' => $this->containerClass ?? null,
                'loading' => $this->loading,
            ],
            'elements' => $this->elements,
        ]);
    }

    /**
     * Listener for element change on view.
     */
    public function dependOn(string $parentUriKey): void
    {
        $this->currentUriKey = $parentUriKey;
        $this->elements = $this->resolveElements($parentUriKey, $this->elements);
    }

    /**
     * Resolve all the elements.
     *
     * @return array<int | float | string | null>
     */
    private function resolveElements(string $parentUriKey, array $elements): array
    {
        // Reset all the elements if parent element is empty
        $this->resetValuesIfParentIsEmpty();

        // Update elements on event (change)
        $this->updateValues();

        // Resolve the child element
        return collect($elements)
            ->map(function ($element) use ($parentUriKey) {
                return $this->resolveChildElements($element);
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get child element from parent.
     */
    private function resolveChildElements(object $element): ?object
    {
        // Get the parent element value
        $parentValue = array_key_exists($element->getParentUriKey(), $this->comboboxValues)
            ? $this->comboboxValues[$element->getParentUriKey()]
            : [];

        // If is the parent element
        if ( ! $parentValue) {
            return $element;
        }

        // Populate the options
        $element->options = app($element->model)
            ->where($element->getForeignKey(), $parentValue)
            ->pluck($element->getChildTableRowValue(), $element->getChildTableRowLabel())
            ->toArray();

        return $element;
    }

    /**
     * Reset the all the elements if parent element is empty.
     */
    private function updateValues(): void
    {
        // Get current position in the array and set the limit
        $limit = $this->getPosition() + 1;

        // Update the values
        $this->comboboxValues = $this->getComboboxValues($limit);
    }

    /**
     * Reset the all the elements if parent element is empty.
     */
    private function resetValuesIfParentIsEmpty(): void
    {
        // Parent element
        $parent = $this->elements[0]->getUriKey();

        // Reset the values
        if (! $this->comboboxValues[$parent]) {
            $this->comboboxValues = [];
            $this->comboboxValues[$parent] = [];
        }
    }

    /**
     * Get the current loop position.
     */
    private function getPosition()
    {
        return (int) array_search(
            $this->currentUriKey,
            array_keys($this->comboboxValues),
        );
    }

    /**
     * Get the visible combobox values.
     *
     * @return array<string, int>
     */
    private function getComboboxValues(int $limit): array
    {
        return array_slice($this->comboboxValues, 0, $limit);
    }
}

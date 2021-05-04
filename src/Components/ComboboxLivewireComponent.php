<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

use Daguilarm\LivewireCombobox\Components\Combobox\DependOn;
use Daguilarm\LivewireCombobox\Components\Combobox\DependOnChild;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Class Combobox Component.
 */
abstract class ComboboxLivewireComponent extends Component
{
    use DependOn,
        DependOnChild;

    /**
     * @var array<string>
     */
    public array $comboboxValues = [];

    /**
     * @var array<Illuminate\Support\Collection>
     */
    public array $elements;

    public bool $loading = true;
    public string $comboboxContainerClass;

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
            'elements' => $this->elements,
            'comboboxContainerClass' => $this->comboboxContainerClass ?? null,
        ]);
    }

    /**
     * Listener for element change on view.
     */
    public function dependOn(string $uriKey): void
    {
        $this->elements = $this->resolveElements($uriKey);
    }
}

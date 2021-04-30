<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

use Daguilarm\LivewireCombobox\Components\Combobox\DependOn;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Class Combobox Component.
 */
abstract class ComboboxLivewireComponent extends Component
{
    use DependOn;

    /**
     * @var array<string>
     */
    public array $comboboxValues = [];

    /**
     * @var string
     */
    public string $comboboxContainerClass;

    /**
     * @var array<Illuminate\Support\Collection>
     */
    public array $elements;

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
    public function dependOn(string $uriKey)
    {
        $this->elements = $this->resolveElements($uriKey);
    }
}

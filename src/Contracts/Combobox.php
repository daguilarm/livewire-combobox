<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Contracts;

interface Combobox
{
    /**
     * List of elements to be render in the view.
     *
     * @return array<Daguilarm\LivewireCombobox\Contracts\Field>
     */
    public function elements(): array;
}

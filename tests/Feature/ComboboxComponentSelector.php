<?php

namespace Daguilarm\LivewireCombobox\Tests\Feature;

use Daguilarm\LivewireCombobox\Tests\App\Http\Livewire\ComboboxSelect;
use Daguilarm\LivewireCombobox\Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// test --filter=ComboboxComponentSelectorTest
class ComboboxComponentSelectorTest extends TestCase
{
    // test --filter=test_combobox_actions
    public function test_combobox_actions(): void
    {
        $this->browse(function($browser) {
            Livewire::visit($browser, ComboboxSelect::class);
        });
    }
}

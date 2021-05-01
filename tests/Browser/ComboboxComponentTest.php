<?php

namespace Daguilarm\LivewireCombobox\Tests\Browser;

use Daguilarm\LivewireCombobox\Tests\BrowserTestCase;
use Daguilarm\LivewireCombobox\Tests\_App\Http\Livewire\ComboboxSelects;

// test --filter=ComboboxComponentTest
class ComboboxComponentTest extends BrowserTestCase
{
    // test --filter=test_combobox_actions
    public function test_combobox_actions(): void
    {
        $this->browse(function($browser) {
            $browser->visit('/testing')
                ->pause(1000);
        });
    }
}

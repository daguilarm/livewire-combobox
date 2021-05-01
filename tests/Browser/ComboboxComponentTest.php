<?php

namespace Daguilarm\LivewireCombobox\Tests\Browser;

use Daguilarm\LivewireCombobox\Tests\TestCase;

// test --filter=ComboboxComponentTest
class ComboboxComponentTest extends TestCase
{
    // test --filter=test_combobox_actions
    public function test_combobox_actions(): void
    {
        $this->browse(function ($browser) {
            $browser->visit('/testing')
                ->assertPresent('#key-for-car')
                ->select('#key-for-car', 1)
                ->assertSelected('#key-for-car', 1)
                ->pause(500)
                ->select('#key-for-options', 1)
                ->assertSelected('#key-for-options', 1);
        });
    }
}

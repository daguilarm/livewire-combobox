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
                // Test Combobox
                ->assertPresent('#key-for-car')
                ->assertSelectHasOptions('#key-for-car', [1, 2])
                ->select('#key-for-car', 1)
                ->assertSelected('#key-for-car', 1)
                ->pause(500)
                ->assertSelectHasOptions('#key-for-options', [1, 2, 3, 4])
                ->select('#key-for-options', 1)
                ->assertSelected('#key-for-options', 1)
                ->pause(500)
                ->assertSelectHasOptions('#key-for-extras', [1, 2])
                ->select('#key-for-extras', 1)
                ->assertSelected('#key-for-extras', 1)
                // Test change value
                ->select('#key-for-car', 2)
                ->assertSelected('#key-for-car', 2)
                ->pause(500)
                ->assertSelectHasOptions('#key-for-options', [5, 6, 7, 8])
                ->assertSelectHasOptions('#key-for-extras', []);
        });
    }
}

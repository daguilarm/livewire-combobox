<?php

namespace Daguilarm\LivewireCombobox\Tests\Browser;

use Daguilarm\LivewireCombobox\Tests\TestCase;

// test --filter=ComboboxComponentTest
class ComboboxComponentTest extends TestCase
{
    // test --filter=test_combobox_selection
    public function test_combobox_selection(): void
    {
        $this->browse(function ($browser) {
            // Test simple dynamic selection
            $browser->visit('/testing')
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

    // test --filter=test_combobox_options
    public function test_combobox_options(): void
    {
        $this->browse(function ($browser) {
            // Test options
            $browser->visit('/testing/options')
                // Testing custom css and attributes
                // @see Daguilarm\LivewireCombobox\Components\FieldComponent::class()
                ->assertSourceHas('id="field-container-for-key-for-car" class="bg-green-500"')
                ->assertSourceHas('id="label-for-key-for-car" class="text-white"')
                // Dusk attribute
                ->assertSourceHas('id="key-for-car" dusk="key_for_car" name="Cars" class="text-green-600"');
        });
    }
}

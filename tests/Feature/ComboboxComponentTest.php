<?php

namespace Daguilarm\LivewireCombobox\Tests\Feature;

use Daguilarm\LivewireCombobox\Tests\App\Http\Livewire\ComboboxSelects;
use Daguilarm\LivewireCombobox\Tests\TestCase;

// test --filter=ComboboxComponentTest
class ComboboxComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    // test --filter=test_combobox_elements
    public function test_combobox_elements(): void
    {
        $combobox = new ComboboxSelects();

        // Testing the number of elements
        $this->assertEquals(count($combobox->elements()), 3);

        // Testing the number of parent elements
        $totalParanetElements = collect($combobox->elements())
            ->filter(function ($element) {
                return ! isset($element->parentUriKey);
            })->count();

        $this->assertEquals($totalParanetElements, 1);
    }
}

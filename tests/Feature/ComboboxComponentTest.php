<?php

namespace Daguilarm\LivewireCombobox\Tests\Feature;

use Daguilarm\LivewireCombobox\Tests\App\Http\Livewire\ComboboxSelect;
use Daguilarm\LivewireCombobox\Tests\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Livewire;

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
        $combobox = new ComboboxSelect();

        // Testing the number of elements
        $this->assertEquals(count($combobox->elements()), 4);

        // Testing the number of parent elements
        $totalParanetElements = collect($combobox->elements())
            ->filter(function($element) {
                return ! isset($element->parentUriKey);
            })->count();

        $this->assertEquals($totalParanetElements, 1);
    }
}

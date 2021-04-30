<?php

namespace Daguilarm\LivewireCombobox\Tests\Unit;

use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Facades\Combobox;
use Daguilarm\LivewireCombobox\Tests\TestCase;

// test --filter=FacadeTest
class FacadeTest extends TestCase
{
    // test --filter=test_facade_value_as_array
    public function test_facade_value_as_array(): void
    {
        $value = ['value' => 100];

        $this->assertEquals(
            Combobox::value($value, 'value'),
            100,
        );
    }

    // test --filter=test_facade_value_as_object
    public function test_facade_value_as_object(): void
    {
        $label = Select::make('My label', User::class);

        $this->assertEquals(
            Combobox::value($label, 'label'),
            'My label',
        );
    }
}

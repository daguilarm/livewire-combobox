<?php

namespace Daguilarm\LivewireCombobox\Tests\Feature;

use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Tests\App\Models\Car;
use Daguilarm\LivewireCombobox\Tests\TestCase;

// test --filter=FieldComponentTest
class FieldComponentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    // test --filter=test_field_has_the_correct_instance
    public function test_field_has_the_correct_instance(): void
    {
        // Testing the instance
        $this->assertInstanceOf(
            $instance = Select::class,
            $class = Select::make('Cars', Car::class),
        );
    }

    // test --filter=test_field_select_has_the_correct_attributes
    public function test_field_select_has_the_correct_attributes(): void
    {
        $options = [1 => 'one', 2 => 'two', 3 => 'three'];
        $select = Select::make('Cars', Car::class)
                ->uriKey('key-for-car')
                ->options($options);

        // Testing the attributes
        $this->assertEquals($select->label, 'Cars');
        $this->assertEquals($select->model, Car::class);
        $this->assertEquals($select->uriKey, 'key-for-car');
        $this->assertEquals($select->options, $options);
    }

    // test --filter=test_field_select_with_callback_has_the_correct_attributes
    public function test_field_select_with_callback_has_the_correct_attributes(): void
    {
        $model = Car::pluck('id', 'name')->toArray();
        $select = Select::make('Cars', Car::class)
                ->options(function ($model) {
                    return $model
                        ->pluck('id', 'name')
                        ->toArray();
                });

        // Testing the callback
        $this->assertEquals($select->options, $model);
    }

    // test --filter=test_field_select_with_dependOn_has_the_correct_attributes
    public function test_field_select_with_dependOn_has_the_correct_attributes(): void
    {
        $select_1 = Select::make('Options 2', Option::class)
                ->uriKey('key-for-option-2')
                ->optionsEmpty()
                ->dependOn('key-for-car', 'cars_id');

        $select_2 = Select::make('Options 2', Option::class)
                ->dependOn('key-for-car')
                ->foreignKey('cars_id');

        // Testing the attributes
        $this->assertEquals($select_1->label, 'Options 2');
        $this->assertEquals($select_1->model, Option::class);
        $this->assertEquals($select_1->options, []);
        $this->assertEquals($select_1->uriKey, 'key-for-option-2');
        $this->assertEquals($select_1->parentUriKey, 'key-for-car');
        $this->assertEquals($select_1->foreignKey, 'cars_id');
        // Testing foreignKey as method
        $this->assertEquals($select_2->parentUriKey, 'key-for-car');
        $this->assertEquals($select_2->foreignKey, 'cars_id');
    }
}

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
        $this->assertEquals($select->getLabel(), 'Cars');
        $this->assertEquals($select->getModel(), Car::class);
        $this->assertEquals($select->getUriKey(), 'key-for-car');
        $this->assertEquals($select->options, $options);
    }

    // test --filter=test_field_select_with_callback_has_the_correct_attributes
    public function test_field_select_with_callback_has_the_correct_attributes(): void
    {
        $model = Car::pluck('name', 'id')->toArray();
        $arrayModel = [
            1 => 'Renault',
            2 => 'Ford',
        ];
        $select = Select::make('Cars', Car::class)
                ->options(function ($model) {
                    return $model
                        ->pluck('name', 'id')
                        ->toArray();
                });

        // Testing the callback
        $this->assertEquals($select->options, $model);
        // Testing array vs elequent
        $this->assertEquals($arrayModel, $model);
    }

    // test --filter=test_field_select_with_dependOn_has_the_correct_attributes
    public function test_field_select_with_dependOn_has_the_correct_attributes(): void
    {
        $select_1 = Select::make('Options 2', Option::class)
                ->uriKey('key-for-option-2')
                ->dependOn('key-for-car', 'cars_id');

        $select_2 = Select::make('Options 2', Option::class)
                ->dependOn('key-for-car')
                ->foreignKey('cars_id');

        // Testing the attributes
        $this->assertEquals($select_1->getLabel(), 'Options 2');
        $this->assertEquals($select_1->getModel(), Option::class);
        $this->assertEquals($select_1->options, []);
        $this->assertEquals($select_1->getUriKey(), 'key-for-option-2');
        $this->assertEquals($select_1->getParentUriKey(), 'key-for-car');
        $this->assertEquals($select_1->getForeignKey(), 'cars_id');
        // Testing foreignKey as method
        $this->assertEquals($select_2->getParentUriKey(), 'key-for-car');
        $this->assertEquals($select_2->getForeignKey(), 'cars_id');
    }
}

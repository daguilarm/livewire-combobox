<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use \Sushi\Sushi;

    protected $rows = [
        ['id' => 1, 'car_id' => 1, 'option' => 'Option Renault 1', 'option_date' => 'Manufactured by Renault in 2010'],
        ['id' => 2, 'car_id' => 1, 'option' => 'Option Renault 2', 'option_date' => 'Manufactured by Renault in 2011'],
        ['id' => 3, 'car_id' => 1, 'option' => 'Option Renault 3', 'option_date' => 'Manufactured by Renault in 2012'],
        ['id' => 4, 'car_id' => 1, 'option' => 'Option Renault 4', 'option_date' => 'Manufactured by Renault in 2013'],
        ['id' => 5, 'car_id' => 2, 'option' => 'Option Ford 1', 'option_date' => 'Manufactured by Ford in 2014'],
        ['id' => 6, 'car_id' => 2, 'option' => 'Option Ford 2', 'option_date' => 'Manufactured by Ford in 2015'],
        ['id' => 7, 'car_id' => 2, 'option' => 'Option Ford 3', 'option_date' => 'Manufactured by Ford in 2016'],
        ['id' => 8, 'car_id' => 2, 'option' => 'Option Ford 4', 'option_date' => 'Manufactured by Ford in 2017'],
        ['id' => 9, 'car_id' => 2, 'option' => 'Option Ford 5', 'option_date' => 'Manufactured by Ford in 2018'],
    ];
}

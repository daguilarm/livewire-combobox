<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use \Sushi\Sushi;

    protected $rows = [
        ['id' => 1, 'name' => 'Renault'],
        ['id' => 2, 'name' => 'ford'],
    ];
}

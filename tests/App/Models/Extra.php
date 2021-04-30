<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Tests\App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use \Sushi\Sushi;

    protected $rows = [
        ['id' => 1, 'option_id' => 1, 'extra' => 'Extra Renault 1'],
        ['id' => 2, 'option_id' => 1, 'extra' => 'Extra Renault 2'],
        ['id' => 3, 'option_id' => 5, 'extra' => 'Extra Ford 1'],
        ['id' => 4, 'option_id' => 5, 'extra' => 'Extra Ford 2'],
    ];
}

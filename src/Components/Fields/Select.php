<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components\Fields;

use Daguilarm\LivewireCombobox\Components\FieldComponent;
use Daguilarm\LivewireCombobox\Contracts\Field;

/**
 * Class Select.
 */
final class Select extends FieldComponent implements Field
{
    /**
     * @var array<Daguilarm\LivewireCombobox\Contracts\Field>
     */
    public array $options = [];

    protected string $type = 'select';
    protected bool $firstRemoved = false;
    protected bool $hideOnEmpty = false;

    /**
     * @var Closure
     */
    protected $optionsCallback;

    /**
     * Init the class.
     *
     * @see Daguilarm\LivewireCombobox\Components\FieldComponent::make()
     */
    public function __construct(public string $label, public ?string $model = null)
    {
    }

    /**
     * Show or hide empty first element.
     */
    public function firstRemoved(bool $value = true): self
    {
        $this->firstRemoved = $value;

        return $this;
    }

    /**
     * Hide the element if has not values.
     */
    public function hideOnEmpty(bool $value = true): self
    {
        $this->hideOnEmpty = $value;

        return $this;
    }

    /**
     * Set the options.
     */
    public function options(array | callable $value): self
    {
        // If callback
        if (is_callable($value)) {
            $this->options = call_user_func($value, new $this->model());

        // If array
        } else {
            $this->options = $value;
        }

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

/**
 * Class Field Component.
 */
abstract class FieldComponent
{
    // Css values
    public ?string $fieldCss = null;
    public ?string $fieldContainerCss = null;
    public ?string $labelCss = null;
    // Base values
    public string $label;
    public string $childTableRowLabel;
    public string $childTableRowValue;
    public string $type;
    public string $uriKey;

    public ?string $model;
    public ?string $foreignKey = null;
    public ?string $parentUriKey = null;

    public int $position = 0;

    public int | float | string | null $defaultValue = null;

    /**
     * Combobox elements values.
     *
     * @var array<string>
     */
    public array $comboboxValues = [];

    /**
     * Filter maker.
     */
    public static function make(string $label, ?string $model = null): FieldComponent
    {
        return new static($label, $model);
    }

    /**
     * Depending element base on uriKey.
     */
    public function class(?string $container = null, ?string $field = null, ?string $label = null): self
    {
        $this->fieldCss = $field;
        $this->fieldContainerCss = $container;
        $this->labelCss = $label;

        return $this;
    }

    /**
     * Depending element base on uriKey.
     */
    public function dependOn(?string $parentUriKey = null, ?string $foreignKey = null): self
    {
        $this->parentUriKey = $parentUriKey;

        if ($foreignKey) {
            $this->foreignKey = $foreignKey;
        }

        return $this;
    }

    /**
     * Set the child element foreignKey.
     */
    public function foreignKey(string $value): self
    {
        $this->foreignKey = $value;

        return $this;
    }

    /**
     * Set the element model.
     */
    public function model(string $value): self
    {
        $this->model = $value;

        return $this;
    }

    /**
     * Set the table rows for the child to be render in the child select.
     */
    public function selectRows(string $label, string $value): self
    {
        $this->childTableRowLabel = $label;
        $this->childTableRowValue = $value;

        return $this;
    }

    /**
     * Set the element uriKey.
     */
    public function uriKey(string $value): self
    {
        $this->uriKey = $value;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

/**
 * Class Field Component.
 */
abstract class FieldComponent
{
    use FieldGetters;

    public int $position = 0;

    /**
     * Combobox elements values.
     *
     * @var array<string>
     */
    public array $comboboxValues = [];

    // Css values
    protected ?string $fieldCss = null;
    protected ?string $fieldContainerCss = null;
    protected ?string $fieldLabelCss = null;

    // Base values
    protected string $label;
    protected string $childTableRowLabel;
    protected string $childTableRowValue;
    protected string $type;
    protected string $uriKey;
    protected ?string $model;
    protected ?string $foreignKey = null;
    protected ?string $parentUriKey = null;
    protected int | float | string | null $defaultValue = null;
    protected bool $withoutResponse = false;
    protected bool $disabledOnEmpty = false;

    /**
     * Field maker.
     */
    public static function make(string $label, ?string $model = null): FieldComponent
    {
        return new static($label, $model);
    }

    /**
     * Depending element base on uriKey.
     */
    public function class(?string $container = null, ?string $label = null, ?string $field = null): self
    {
        $this->fieldContainerCss = $container;
        $this->fieldLabelCss = $label;
        $this->fieldCss = $field;

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
     * Disable field if it is empty.
     */
    public function disabledOnEmpty(bool $value = true): void
    {
        $this->disabledOnEmpty = $value;
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

    /**
     * Element without livewire response.
     */
    public function withoutResponse(): self
    {
        $this->withoutResponse = true;

        return $this;
    }
}

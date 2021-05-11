<?php

declare(strict_types=1);

namespace Daguilarm\LivewireCombobox\Components;

/**
 * Class field getters.
 */
trait FieldGetters
{
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getFieldCss(): ?string
    {
        return $this->fieldCss;
    }

    public function getFieldContainerCss(): ?string
    {
        return $this->fieldContainerCss;
    }

    public function getFieldLabelCss(): ?string
    {
        return $this->fieldLabelCss;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUriKey(): string
    {
        return $this->uriKey;
    }

    public function getDefaultValue(): int | float | string | null
    {
        return $this->defaultValue;
    }

    public function getWithoutResponse(): bool
    {
        return $this->withoutResponse;
    }

    public function getHideOnEmpty(): bool
    {
        return $this->hideOnEmpty;
    }

    public function getFirstRemoved(): bool
    {
        return $this->firstRemoved;
    }

    public function getForeignKey(): ?string
    {
        return $this->foreignKey;
    }

    public function getParentUriKey(): ?string
    {
        return $this->parentUriKey;
    }

    public function getChildTableRowLabel()
    {
        return $this->childTableRowLabel ?? '';
    }

    public function getChildTableRowValue()
    {
        return $this->childTableRowValue ?? '';
    }
}

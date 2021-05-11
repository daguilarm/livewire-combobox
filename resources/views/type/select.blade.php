@php
    $totalOptions = count($element->options);
@endphp

@unless ($totalOptions <= 0 && $element->getHideOnEmpty() === true)
    {{-- Field main container --}}
    <div
        id="field-container-for-{{ $element->getUriKey() }}"
        class="{{ $element->getFieldContainerCss() ?? 'px-2' }}"
    >
        {{-- Label --}}
        <label
            id="label-for-{{ $element->getUriKey() }}"
            class="{{ $element->getFieldLabelCss() ?? 'block w-full text-sm font-medium text-gray-600' }}"
            for="{{ $element->getUriKey() }}"
        >
            {{ $element->label }}
        </label>
        {{-- Field --}}
        <select
            id="{{ $element->getUriKey() }}"
            dusk="{{ Str::of($element->getUriKey())->replace('-', '_') }}"
            name="{{ $element?->label  ?? $element->getUriKey() }}"
            class="{{ $element->getFieldCss() ?? 'bg-white w-full relative border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 mt-1 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' }}"

            {{-- Disable empty elements --}}
            @if($element->disabledOnEmpty() && $element->getTotalOptions() <= 0)
                disabled
            @endif

            {{-- Last element or element without Livewire Response --}}
            @unless ($element->getWithoutResponse())
                wire:model.defer="comboboxValues.{{ $element->getUriKey() }}"
                wire:change="$emit('dependOn', '{{ $element->getUriKey() }}')"
            @endunless
        >
            {{-- Show or hide empty first element --}}
            @unless ($element->getFirstRemoved())
                <option value=""></option>
            @endunless

            {{-- Options --}}
            @foreach ($element->getOptions() as $key => $value)
                <option
                    value="{{ $key ?? $element->defaultValue }}"
                    {{-- Selected option for childs --}}
                    @if(is_object($element) && $element->getDefaultValue() === $key)
                        selected
                    @endif
                >
                    {{ $value }}
                </option>
            @endforeach
        </select>
    </div>
@endunless

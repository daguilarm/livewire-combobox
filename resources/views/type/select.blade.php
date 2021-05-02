<div
    class="{{ Combobox::value($element, 'fieldContainerCss') ?? 'px-2' }}"
    id="field-container-for-{{ Combobox::value($element, 'uriKey') }}"
>
    <label
        id="{{ Combobox::value($element, 'uriKey') }}-label"
        class="{{ Combobox::value($element, 'labelCss') ?? 'block w-full text-sm font-medium text-gray-600' }}"
        for="{{ Combobox::value($element, 'uriKey') }}"
    >
        {{ Combobox::value($element, 'label') }}
    </label>
    <select
        id="{{ Combobox::value($element, 'uriKey') }}"
        dusk="{{ Str::of(Combobox::value($element, 'uriKey'))->replace('-', '_') }}"
        name="{{ $element?->label  ?? $element['uriKey'] }}"
        class="{{ Combobox::value($element, 'fieldCss') ?? 'bg-white w-full relative border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 mt-1 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm' }}"
        wire:model.defer="comboboxValues.{{ Combobox::value($element, 'uriKey') }}"
        wire:change="$emit('dependOn', '{{ Combobox::value($element, 'uriKey') }}')"
    >
        {{-- Show or hide empty first element --}}
        @unless(Combobox::value($element, 'firstRemoved'))
            <option></option>
        @endunless

        @foreach(Combobox::value($element, 'options') as $key => $value)
            <option
                value="{{ $key ?? Combobox::value($element, 'defaultValue') }}"
                @if(is_array($element) && $element['defaultValue'] == $key)
                    selected
                @endif
            >
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>

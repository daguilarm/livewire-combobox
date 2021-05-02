<div class="{{ $comboboxContainerClass ?? 'flex' }}">
    @foreach ($elements as $element)
        {{-- Include a select field --}}
        @includeWhen(Combobox::value($element, 'type') === 'select', 'livewire-combobox::type.select')
    @endforeach
</div>

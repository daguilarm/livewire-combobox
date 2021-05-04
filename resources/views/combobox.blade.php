<div class="{{ $comboboxContainerClass ?? 'flex' }}">

    {{-- Elements --}}
    @foreach ($elements as $element)
        {{-- Include a select field --}}
        @includeWhen(Combobox::value($element, 'type') === 'select', 'livewire-combobox::type.select')
    @endforeach

    {{-- Loading --}}
    @if ($loading)
        @include('livewire-combobox::loading')
    @endif
</div>

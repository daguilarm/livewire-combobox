<div class="{{ $config['containerClass'] ?? 'flex' }}">

    {{-- Elements --}}
    @foreach ($elements as $element)
        {{-- Include a select field --}}
        @includeWhen(
            $element->getType() === 'select',
            'livewire-combobox::type.select'
        )
    @endforeach

    {{-- Loading --}}
    @if ($config['loading'])
        @include('livewire-combobox::loading')
    @endif
</div>

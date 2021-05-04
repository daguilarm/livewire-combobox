<div class="{{ $comboboxContainerClass ?? 'flex' }}">

    {{-- Elements --}}
    @foreach ($elements as $element)
        {{-- Include a select field --}}
        @includeWhen(Combobox::value($element, 'type') === 'select', 'livewire-combobox::type.select')
    @endforeach

    {{-- Loading --}}
    @if ($loading)
        <div class="flex relative" wire:loading>
            <div class="fixed">
                @include('livewire-combobox::loading')
            </div>
        </div
    @endif
</div>

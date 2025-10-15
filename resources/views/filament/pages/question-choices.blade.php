<x-filament-panels::page>

    <x-filament::section>
        <x-slot name="heading">
            Pertanyaan
        </x-slot>

        {!! $this->question_id->question_text !!}
    </x-filament::section>


    {{ $this->table }}
</x-filament-panels::page>

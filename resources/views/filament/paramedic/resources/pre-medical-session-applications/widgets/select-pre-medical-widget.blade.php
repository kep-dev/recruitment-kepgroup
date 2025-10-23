<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::input.wrapper>
            <x-filament::input.select wire:model.change="jobVacancyId">
                <option value="">--- Pilih Lowongan ---</option>
                @foreach ($this->jobVacancies as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </x-filament::section>
</x-filament-widgets::widget>

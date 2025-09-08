<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
        
        <x-filament::button type="submit">
            Save Statistics
        </x-filament::button>
    </x-filament-panels::form>
</x-filament-panels::page>
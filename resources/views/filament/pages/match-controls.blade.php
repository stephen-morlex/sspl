<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6">
        <x-filament::section>
            <x-slot name="heading">
                Match Controls
            </x-slot>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-filament::button color="success">
                    Start Match
                </x-filament::button>

                <x-filament::button color="warning">
                    Pause Match
                </x-filament::button>

                <x-filament::button color="danger">
                    End Match
                </x-filament::button>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Quick Event Entry
            </x-slot>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-filament::button>
                    Goal
                </x-filament::button>

                <x-filament::button color="warning">
                    Yellow Card
                </x-filament::button>

                <x-filament::button color="danger">
                    Red Card
                </x-filament::button>

                <x-filament::button>
                    Substitution
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
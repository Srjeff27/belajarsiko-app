<x-filament-panels::page>
    <div class="max-w-2xl">
        <form wire:submit.prevent="save">
            {{ $this->form }}
            <div class="mt-6">
                <x-filament::button type="submit" icon="heroicon-o-check">
                    Simpan
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>

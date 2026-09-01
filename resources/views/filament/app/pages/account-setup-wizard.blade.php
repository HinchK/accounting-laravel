<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="description">
            Configure your company and accounting preferences, then add only the connections you plan to use. Secrets are encrypted at rest and never shown again after saving.
        </x-slot>

        @if ($this->configuredIntegrations !== [])
            <div class="mb-6 rounded-lg bg-success-50 p-4 text-sm text-success-800 dark:bg-success-950 dark:text-success-200">
                Connected credentials are already saved for: {{ collect($this->configuredIntegrations)->map(fn (string $provider): string => strtoupper($provider))->join(', ', ' and ') }}.
                Leave a credential field blank to keep it unchanged.
            </div>
        @endif

        {{ $this->content }}
    </x-filament::section>
</x-filament-panels::page>

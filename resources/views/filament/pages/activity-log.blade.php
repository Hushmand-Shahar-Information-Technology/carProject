<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                    {{ __('common.navigation.activity_log') }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ __('common.messages.view_all_activities') }}
                </p>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
            {{ $this->table }}
        </div>
    </div>
    
    @assets
    <style>
        .filament-tables-table td, 
        .filament-tables-table th {
            white-space: nowrap;
        }
        
        @media (min-width: 768px) {
            .filament-tables-table td, 
            .filament-tables-table th {
                white-space: normal;
            }
        }
        
        .filament-tables-text-column .filament-tables-column-wrapper {
            display: flex;
            flex-direction: column;
        }
        
        .filament-tables-text-column .description {
            font-size: 0.85rem;
            opacity: 0.8;
        }
    </style>
    @endassets
</x-filament-panels::page>
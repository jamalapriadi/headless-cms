<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            @can('view settings')
                <flux:navlist.item :href="route('dashboard.settings')" wire:navigate>{{ __('Summary') }}</flux:navlist.item>
            @endcan

            @can('view users')
                <flux:navlist.item :href="route('dashboard.settings.users')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
            @endcan

            @can('view roles')
                <flux:navlist.item :href="route('dashboard.settings.roles')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
            @endcan
            
            @can('view permissions')
                <flux:navlist.item :href="route('dashboard.settings.permissions')" wire:navigate>{{ __('Permissions') }}</flux:navlist.item>
            @endcan

            <flux:separator class="mt-4 mb-4" />
            @can('view languages')
                <flux:navlist.item :href="route('dashboard.languages')" wire:navigate>{{ __('Languages') }}</flux:navlist.item>
            @endcan
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>

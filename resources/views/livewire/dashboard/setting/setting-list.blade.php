<section class="w-full">
    @include('partials.settings-rbac')

    <x-settings.rbac :heading="__('Settings')" :subheading="__('Manage your dashboard settings and preferences')">
        <flux:separator class="mb-4 mt-4" />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Users Card -->
            <a href="{{ route('dashboard.settings.users') }}" class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">
                    {{ $usersCount ?? 0 }}
                </div>
                <div class="text-gray-700 text-lg font-semibold">
                    {{ __('Users') }}
                </div>
            </a>

            <!-- Roles Card -->
            <a href="{{ route('dashboard.settings.roles') }}" class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-green-600 mb-2">
                    {{ $rolesCount ?? 0 }}
                </div>
                <div class="text-gray-700 text-lg font-semibold">
                    {{ __('Roles') }}
                </div>
            </a>

            <!-- Permissions Card -->
            <a href="{{ route('dashboard.settings.permissions') }}" class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">
                    {{ $permissionsCount ?? 0 }}
                </div>
                <div class="text-gray-700 text-lg font-semibold">
                    {{ __('Permissions') }}
                </div>
            </a>
        </div>
    </x-settings.rbac>

</section>

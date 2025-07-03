<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <flux:callout variant="secondary" inline>
        <flux:callout.heading>
            Welcome back, {{auth()->user()->name}}!
        </flux:callout.heading>
        <flux:callout.text>
            You have full access to manage posts, pages, and categories.
        </flux:callout.text>
    </flux:callout>

    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative flex flex-col justify-center items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="absolute top-4 left-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                Posts Overview
            </div>
            <div class="flex flex-row items-center justify-center gap-8 w-full">
                <div class="flex flex-col items-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $totalPosts }}
                    </div>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        Total Posts
                    </div>
                </div>
                <flux:separator vertical />
                <div class="flex flex-col items-center">
                    <span class="text-lg font-semibold text-green-600 dark:text-green-400">{{ $totalPostsPublished }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-300">Published</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $totalPostsDraft }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-300">Draft</span>
                </div>
            </div>
        </div>

        <div class="relative flex flex-col justify-center items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="absolute top-4 left-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                Pages Overview
            </div>
            <div class="flex flex-row items-center justify-center gap-8 w-full">
                <div class="flex flex-col items-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $totalPages }}
                    </div>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        Total Pages
                    </div>
                </div>
                <flux:separator vertical />
                <div class="flex flex-col items-center">
                    <span class="text-lg font-semibold text-green-600 dark:text-green-400">{{ $totalPagesPublished }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-300">Published</span>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-lg font-semibold text-yellow-600 dark:text-yellow-400">{{ $totalPagesDraft }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-300">Draft</span>
                </div>
            </div>
        </div>

        <div class="relative flex flex-col justify-center items-center aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-900">
            <div class="absolute top-4 left-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                Categories Overview
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $totalCategories }}
            </div>
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                Total Categories
            </div>
        </div>
    </div>
</div>
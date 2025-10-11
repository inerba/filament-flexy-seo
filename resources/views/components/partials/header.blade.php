<div class="drawer drawer-end">
    <input id="my-drawer-5" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <div class="bg-white border-b">
            <div class="flex items-center justify-between px-4 py-6 mx-auto max-w-7xl md:py-12 xl:px-0">
                <x-logo class="w-64 font-display" />

                <div class="items-center hidden lg:flex">
                    <livewire:cms.menu slug="main-menu" />
                    <a href="" class="ml-4">
                        @svg('heroicon-o-magnifying-glass', 'size-6 text-gray-700')
                    </a>
                </div>

                <label for="my-drawer-5" class="flex lg:hidden drawer-button">@svg('heroicon-o-bars-2', 'size-8 text-gray-900', ['x-on:click' => 'onOpen'])</label>
            </div>

            <!-- Page content here -->
        </div>

    </div>
    <div class="drawer-side">
        <label for="my-drawer-5" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="menu bg-base-200 min-h-full w-80 p-4">
            <livewire:cms.menu slug="main-menu" variant="-sidebar" />
        </div>
    </div>
</div>


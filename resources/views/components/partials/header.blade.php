<div class="bg-white border-b">
    <div class="flex items-center justify-between px-4 py-6 mx-auto max-w-7xl md:py-12 xl:px-0">
        <x-logo class="w-64 font-display" />

        <div class="items-center hidden lg:flex">
            <livewire:cms.menu slug="main-menu" />
            <a href="" class="ml-4">
                @svg('heroicon-o-magnifying-glass', 'size-6 text-gray-700')
            </a>
        </div>
        <div class="flex lg:hidden" x-data="{
            onOpen() {
                alert('Open');
            }
        }">
            @svg('heroicon-o-bars-2', 'size-8 text-gray-900', ['x-on:click' => 'onOpen'])
        </div>
    </div>
</div>


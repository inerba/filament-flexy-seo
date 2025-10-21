<div class="drawer drawer-end">
    <input id="my-drawer-5" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
        <div class="bg-white border-b">
            <div class="flex items-center justify-between px-4 py-6 mx-auto max-w-7xl md:py-12 xl:px-0">
                <x-logo class="w-64 font-display" />

                <div class="items-center hidden lg:flex">
                    <livewire:cms.menu slug="main-menu"/>
                    {{-- <a href="" class="ml-4">
                        @svg('heroicon-o-magnifying-glass', 'size-6 text-gray-700')
                    </a> --}}
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-usermenu.dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>
                                        @svg('heroicon-o-user-circle', 'size-7 text-gray-700')
                                    </div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @guest('customer')
                                    <x-usermenu.dropdown-link :href="route('login')">
                                        {{ __('Log In') }}
                                    </x-usermenu.dropdown-link>
                                @endguest

                                @auth('customer')
                                    <div class="px-4 py-2 font-bold font-display border-b border-gray-500">
                                        {{ Auth::guard('customer')->user()->name }}
                                    </div>
                                @endauth

                                @auth('customer')
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-usermenu.dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-usermenu.dropdown-link>
                                    </form>
                                @endauth
                            </x-slot>
                        </x-usermenu.dropdown>
                    </div>

                    <livewire:shop.navigation-cart lazy />
                </div>

                <div class="flex lg:hidden">
                    <livewire:shop.navigation-cart class="flex mr-3" lazy />
                    <label for="my-drawer-5" class="flex drawer-button">@svg('heroicon-o-bars-2', 'size-8 text-gray-900', ['x-on:click' => 'onOpen'])</label>
                </div>
            </div>

            <!-- Page content here -->
        </div>

    </div>
    <div class="drawer-side">
        <label for="my-drawer-5" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="menu bg-base-200 min-h-full w-80 p-4">
            <livewire:cms.menu slug="main-menu" variant="-sidebar" lazy />
        </div>
    </div>
</div>


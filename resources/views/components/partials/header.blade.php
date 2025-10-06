<section x-data="{ mobileNavOpen: false }" class="overflow-hidden">
    <nav class="px-4 py-4 lg:px-10 lg:py-7">
        <div class="flex items-center justify-between">
            <x-logo class="relative z-10 pr-4 lg:pr-0" href="/" />

            <button x-on:click="mobileNavOpen = !mobileNavOpen" class="xl:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="14" viewBox="0 0 34 14" fill="none">
                    <g clip-path="url(#clip0_231_4713)">
                        <rect width="34" height="3" rx="1.5" fill="#19191B"></rect>
                        <rect y="11" width="34" height="3" rx="1.5" fill="#19191B"></rect>
                    </g>
                    <defs>
                        <clipPath id="clip0_231_4713">
                            <rect width="34" height="14" fill="white"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </button>
        </div>
    </nav>

    <div :class="{ 'block': mobileNavOpen, 'hidden': !mobileNavOpen }" class="fixed bottom-0 left-0 top-0 z-[9999] hidden w-5/6 max-w-xs">
        <div x-on:click="mobileNavOpen = !mobileNavOpen" class="fixed inset-0 bg-black opacity-20"></div>
        <nav class="relative h-full w-full overflow-y-auto bg-white p-8">
            <div class="flex h-full flex-col justify-between">
                <div>
                    <div class="mb-8 flex items-center justify-between">
                        <a class="pr-4" href="#">
                            <x-logo />
                        </a>
                        <button x-on:click="mobileNavOpen = !mobileNavOpen">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#252E4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <g clip-path="url(#clip0_231_6677)">
                                <path
                                    d="M19.6343 17.871L15.7634 13.9984C18.6598 10.1278 17.87 4.64195 13.9994 1.74551C10.1288 -1.15092 4.64292 -0.361157 1.74649 3.50949C-1.14994 7.38013 -0.36018 12.866 3.51046 15.7624C6.61969 18.0891 10.8901 18.0891 13.9994 15.7624L17.872 19.635C18.3587 20.1216 19.1477 20.1216 19.6343 19.635C20.121 19.1483 20.121 18.3593 19.6343 17.8727L19.6343 17.871ZM8.7872 15.015C5.34716 15.015 2.55848 12.2263 2.55848 8.78623C2.55848 5.34618 5.34716 2.55751 8.7872 2.55751C12.2273 2.55751 15.0159 5.34618 15.0159 8.78623C15.0123 12.2247 12.2257 15.0113 8.7872 15.015Z"
                                    fill="#19191B"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_231_6677">
                                    <rect width="20" height="20" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div>
                <div class="flex flex-col gap-8 py-16">

                </div>
                {{-- <div class="flex flex-col items-center gap-2">
                    <a class="inline-flex h-16 w-full items-center justify-center rounded-lg border border-neutral-900 bg-transparent p-5 text-center text-lg font-semibold tracking-tight transition duration-200 hover:bg-neutral-900 hover:text-white focus:bg-neutral-900 focus:text-white focus:ring-4 focus:ring-neutral-400"
                        href="#">
                        Help
                    </a>
                    <a class="inline-flex h-16 w-full items-center justify-center rounded-lg border border-neutral-900 bg-transparent p-5 text-center text-lg font-semibold tracking-tight transition duration-200 hover:bg-neutral-900 hover:text-white focus:bg-neutral-900 focus:text-white focus:ring-4 focus:ring-neutral-400"
                        href="#">
                        Sign up free
                    </a>
                </div> --}}
            </div>
        </nav>
    </div>
</section>
<nav class="sticky top-0 z-50 hidden h-auto items-center justify-center border-b border-t border-gray-300 bg-white/60 px-10 backdrop-blur-[2px] lg:flex">
    <livewire:cms.menu slug="main-menu" />
</nav>

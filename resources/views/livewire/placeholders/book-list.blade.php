<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12 lg:gap-x-24">
    @for ($i = 0; $i < 6; $i++)
        <div class="flex gap-6 group md:hover:scale-110 transition-transform">
            <div class="shrink-0">

                <div class="w-32 h-48 bg-gray-200 flex items-center justify-center shimmer">
                    <span class="text-gray-500"></span>
                </div>
            </div>
            <div class="w-full">
                <div class="shimmer w-3/4 h-3 mb-2"></div>
                <div class="shimmer w-full h-6 mb-2"></div>
                <div class="shimmer w-4/5 h-6 mb-2 "></div>
                <div class="shimmer w-3/4 h-6"></div>
                <div class="border-b-2 w-12 my-4"></div>
                <div class="shimmer w-full h-3 mb-2"></div>
                <div class="shimmer w-full h-3 mb-2"></div>
                <div class="shimmer w-full h-3 mb-2"></div>
                <div class="shimmer w-full h-3 mb-2"></div>
                <div class="shimmer w-5/6 h-3 mb-2"></div>
            </div>
        </div>
    @endfor
</div>

<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center justify-between gap-x-3">
            <div class="flex-1">
                <svg class="size-10" xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 256 256">
                    <path d="M216.71,99.73l-15.6,93.59a8,8,0,0,1-7.89,6.68H62.78a8,8,0,0,1-7.89-6.68L39.29,99.73l.08,0a19.82,19.82,0,0,0,9.22-4.16h0L88,144l32-73.65h0a20,20,0,0,0,15.92,0h0L168,144l39.39-48.48h0a19.82,19.82,0,0,0,9.22,4.16Z"
                        opacity="0.2"></path>
                    <path
                        d="M248,80a28,28,0,1,0-51.12,15.77l-26.79,33L146,73.4a28,28,0,1,0-36.06,0L85.91,128.74l-26.79-33a28,28,0,1,0-26.6,12L47,194.63A16,16,0,0,0,62.78,208H193.22A16,16,0,0,0,209,194.63l14.47-86.85A28,28,0,0,0,248,80ZM128,40a12,12,0,1,1-12,12A12,12,0,0,1,128,40ZM24,80A12,12,0,1,1,36,92,12,12,0,0,1,24,80ZM193.22,192H62.78L48.86,108.52,81.79,149A8,8,0,0,0,88,152a7.83,7.83,0,0,0,1.08-.07,8,8,0,0,0,6.26-4.74l29.3-67.4a27,27,0,0,0,6.72,0l29.3,67.4a8,8,0,0,0,6.26,4.74A7.83,7.83,0,0,0,168,152a8,8,0,0,0,6.21-3l32.93-40.52ZM220,92a12,12,0,1,1,12-12A12,12,0,0,1,220,92Z">
                    </path>
                </svg>
            </div>

            <div>
                Completissimo
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link color="gray" href="https://github.com/inerba/postare-kit-12" icon="heroicon-m-book-open" icon-alias="panels::widgets.filament-info.open-documentation-button" rel="noopener noreferrer" target="_blank">
                    {{ __('filament-panels::widgets/filament-info-widget.actions.open_documentation.label') }}
                </x-filament::link>

                <x-filament::link color="gray" href="https://github.com/inerba/postare-kit-12#postare-kit-12" icon-alias="panels::widgets.filament-info.open-github-button" rel="noopener noreferrer" target="_blank">
                    <x-slot name="icon">
                        <svg viewBox="0 0 98 96" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill="currentColor" fill-rule="evenodd"
                                d="M48.854 0C21.839 0 0 22 0 49.217c0 21.756 13.993 40.172 33.405 46.69 2.427.49 3.316-1.059 3.316-2.362 0-1.141-.08-5.052-.08-9.127-13.59 2.934-16.42-5.867-16.42-5.867-2.184-5.704-5.42-7.17-5.42-7.17-4.448-3.015.324-3.015.324-3.015 4.934.326 7.523 5.052 7.523 5.052 4.367 7.496 11.404 5.378 14.235 4.074.404-3.178 1.699-5.378 3.074-6.6-10.839-1.141-22.243-5.378-22.243-24.283 0-5.378 1.94-9.778 5.014-13.2-.485-1.222-2.184-6.275.486-13.038 0 0 4.125-1.304 13.426 5.052a46.97 46.97 0 0 1 12.214-1.63c4.125 0 8.33.571 12.213 1.63 9.302-6.356 13.427-5.052 13.427-5.052 2.67 6.763.97 11.816.485 13.038 3.155 3.422 5.015 7.822 5.015 13.2 0 18.905-11.404 23.06-22.324 24.283 1.78 1.548 3.316 4.481 3.316 9.126 0 6.6-.08 11.897-.08 13.526 0 1.304.89 2.853 3.316 2.364 19.412-6.52 33.405-24.935 33.405-46.691C97.707 22 75.788 0 48.854 0z" />
                        </svg>
                    </x-slot>

                    {{ __('filament-panels::widgets/filament-info-widget.actions.open_github.label') }}
                </x-filament::link>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

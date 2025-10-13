<div>
    @if ($this->count > 0)
        <div @class(['flex', $class ?? ''])>
            <a href="{{ route('shop.cart') }}" class="ml-4 relative">
                @svg('phosphor-basket-duotone', 'size-8 text-gray-700')
                <span
                    class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center size-6 font-display text-xs font-medium text-white bg-primary-600/80 border-2 border-white rounded-full">
                    {{ $this->count }}
                </span>
            </a>
        </div>
    @endif
</div>


<nav id="main-menu">
    <div class="flex flex-col gap-1">
        @if (is_array($items))
            @forelse ($items as $item)
                <a href="{{ $item['url'] }}" @if ($item['target']) target="{{ $item['target'] }}" @endif @if ($item['rel']) rel="{{ $item['rel'] }}" @endif
                    class="@if (active_route($item['url'])) text-black @endif underline">
                    {{ $item['label'] }}
                </a>
            @empty
                <span class="text-gray-500">No menu items found.</span>
            @endforelse
        @endif
    </div>
</nav>

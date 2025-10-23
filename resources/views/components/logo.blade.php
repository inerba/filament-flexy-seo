<a wire:navigate.hover href="/" {{ $attributes->merge(['class' => 'flex items-center group gap-2']) }}>
    <div class="w-12 -my-6 shrink-0 md:mr-4 md:w-24 animate-[spin_1500ms_ease-in-out_2_reverse_2s]">
        <x-pictogram class="fill-stone-900 group-hover:animate-[spin_1500ms_ease-in-out_reverse]" />
        {{-- <x-pictogram-inverted /> --}}
    </div>
    <div
        class="text-primary-500 whitespace-nowrap text-center font-['Courier_New'] text-xl font-bold leading-none tracking-wider md:text-3xl md:tracking-widest">
        CLUSTER-A
    </div>
</a>


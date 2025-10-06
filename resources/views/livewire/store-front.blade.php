<div class="prose grid max-w-none grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
    @foreach ($this->products as $product)
        <div class="border p-4">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p>Price: {{ format_money($product->price) }}</p>
        </div>
    @endforeach
</div>

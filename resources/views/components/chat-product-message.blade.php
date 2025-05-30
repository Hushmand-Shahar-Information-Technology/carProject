<div>
    <strong>{{ $product->name }}</strong><br>
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px;"><br>
    <a href="{{ route('product.show', $product->id) }}" target="_blank">View Product</a>
</div>
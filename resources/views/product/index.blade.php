<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
</head>
<body>
<h1>Product Details</h1>
@foreach ($products as $product)
    <div>
        <h2>{{ $product->title }}</h2>
        <p>Price: ${{ $product->price }}</p>
        <p>Created At: {{ $product->created_at->format('Y-m-d H:i:s') }}</p>

    </div>
@endforeach

</body>
</html>

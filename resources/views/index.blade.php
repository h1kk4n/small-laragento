@php
    /**
     * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Product> $products
     */
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laragento</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <main class="content">
            <div class="container">
                <section class="products-list">
                    @if (!$products->isEmpty())
                        @foreach ($products as $product)
                            <div class="product">
                                <div class="product-name">{{ $product->name }} (SKU: {{ $product->sku }})</div>
                                <div class="product-price">{{ round($product->price, 2) }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-products">No products yet.</div>
                    @endif
                </section>
            </div>
        </main>
    </body>
</html>

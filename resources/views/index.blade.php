@php
/**
 * @var \Illuminate\Database\Eloquent\Collection<\App\Models\Product> $products
 * @var \App\Models\Cart|null $cart
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
                <section class="product-list">
                    <h3>Product list:</h3>
                    @if (!$products->isEmpty())
                        @foreach ($products as $product)
                            <div class="product">
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }} (SKU: {{ $product->sku }})</div>
                                    <div class="product-price">
                                        Price: <span class="product-price-value">{{ round($product->price, 2) }}</span>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <form method="POST" action="/cart">
                                        @csrf
                                        <input type="hidden" name="product-id" value="{{ $product->id }}">
                                        <button type="submit"
                                                class="product-add-button"
                                        >Add</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-products">No products yet</div>
                    @endif
                </section>
                <section class="cart">
                    <h3 class="cart-header">Your cart:</h3>
                    <div class="cart-container">
                        @if ($cart?->items->count())
                            <div class="cart-items">
                                @foreach ($cart->items as $item)
                                    <div class="cart-item">
                                        <div class="cart-item-info">
                                            <div class="cart-item-name">{{ $item->product->name }}</div>
                                            <div class="cart-item-price">Price: {{ $item->final_price }} RUB</div>
                                        </div>
                                        <div class="cart-item-actions">
                                            <form method="POST" action="/cart/{{ $item->id }}">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="qty-increment" value="0">
                                                <button class="decrease-qty">-</button>
                                            </form>
                                            <div class="cart-item-qty">{{ $item->qty }}</div>
                                            <form method="POST" action="/cart/{{ $item->id }}">
                                                @method('put')
                                                @csrf
                                                <input type="hidden" name="qty-increment" value="1">
                                                <button class="increase-qty">+</button>
                                            </form>
                                            <form method="POST" action="/cart/{{ $item->id }}">
                                                @method('delete')
                                                @csrf
                                                <button class="remove-item">x</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cart-total">
                                <div class="cart-item-info">
                                    <div class="cart-total-qty">Total: {{ $cart->total_qty }} items</div>
                                </div>
                                <div class="cart-total-summary">
                                    <div class="cart-total-price">{{ $cart->total_price }} RUB</div>
                                </div>
                            </div>
                            <div class="place-order-block">
                                <form method="POST" action="/cart/order">
                                    @csrf
                                    <button type="submit" class="place-order-button">Place Order</button>
                                </form>
                            </div>
                        @else
                            <div class="empty-cart">No items yet</div>
                        @endif
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>

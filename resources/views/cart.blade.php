@extends('layouts.main')

@section('content')

<main>

    <form id="cart-form" action="{{ route('cart-update') }}" method="POST">
        @csrf
        <table border="1">
            <thead>
                <tr>
                    <th>name</th>
                    <th>amount</th>
                    <th>price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td><a href="{{ route('product-view', ['product' => $product->code]) }}">{{ $product->name }}</a></td>
                    <td><input type="number" value="{{ $product->pivot->amont }}" name="items[{{ $product->id }}][amont]"></td>
                    <td>
                        <input type="hidden" value="{{ $product->price }}" name="items[{{ $product->id }}][itemPrice]">
                        {{ $product->pivot->price }}
                    </td>
                    <td><a href="{{ route('cart-remove-product', ['product' => $product->code]) }}">Remove</a></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4">{{ $cart->total_price }}</td>
                </tr>
            </tbody>
        </table>
        <button type="submit" id="update-cart-btn" disabled>Update Cart</button>
    </form>
</main>

<script>
    // Check if there are items in the cart and enable/disable the update cart button accordingly
    document.addEventListener('DOMContentLoaded', function() {
        var cartForm = document.getElementById('cart-form');
        var updateCartBtn = document.getElementById('update-cart-btn');

        if (cartForm.querySelectorAll('input[type="number"]').length > 0) {
            updateCartBtn.disabled = false;
        } else {
            updateCartBtn.disabled = true;
        }
    });
</script>

@endsection

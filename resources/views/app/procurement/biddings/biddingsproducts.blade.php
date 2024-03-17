@extends('layouts/layoutMaster')

@section('content')

@foreach ($biddingProducts as $product)
<div class="product-container" data-product-id="{{ $product->id }}">
  <h2>{{ $product->name }}</h2>
  <p>Current Bid: <span class="current-bid">{{ $product->starting_price }}</span></p>
  <div class="bid-history">
    <h3>Bid History</h3>
    <ul class="bid-list">
      </ul>
  </div>
</div>

@endforeach

<script>
 import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-app-key',
    cluster: 'your-pusher-cluster',
    wsHost: window.location.hostname, // Assuming WebSocket server on same host
    wsPort: 6001,
    forceTLS: false, // Adjust if not using TLS
    disableStats: true
});

// Example: Listen on a channel tied to the product ID
window.Echo.channel('product-bids.{{ $product->id }}')
    .listen('NewBid', (event) => {
        const bidList = document.querySelector(`[data-product-id="${event.bid.product_id}"] .bid-list`);
        const newBidItem = document.createElement('li');
        newBidItem.textContent = `Bid: ${event.bid.amount}`;
        bidList.appendChild(newBidItem);
    });

</script>

@endsection

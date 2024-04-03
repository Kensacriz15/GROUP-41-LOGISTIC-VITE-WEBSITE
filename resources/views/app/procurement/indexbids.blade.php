@extends('layouts.layoutMaster')

@section('title', 'Bid Listings')

@section('content')
    <h2 class="text-center">Bidding Products</h2>

    <div class="row">
        @foreach ($biddingProducts as $product)
            <div class="col-md-2 mb-2">
                <div class="card" style="max-width: 150px;">
                    <img class="card-img-top" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <a href="{{ route('app.procurement.listbids', ['productId' => $product->id]) }}" class="btn btn-sm btn-primary">View Bids</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $biddingProducts->links() }}
@endsection

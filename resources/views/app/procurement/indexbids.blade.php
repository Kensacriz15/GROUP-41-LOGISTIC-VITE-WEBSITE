@extends('layouts.layoutMaster')

@section('title', 'Bid Listings')

@section('content')
    <h1>Bidding Products</h1>

    <div class="row">
        @foreach ($biddingProducts as $product)
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <a href="{{ route('app.procurement.listbids', ['productId' => $product->id]) }}" class="btn btn-primary">View Bids</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $biddingProducts->links() }}
@endsection

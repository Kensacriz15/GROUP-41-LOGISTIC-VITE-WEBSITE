@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>{{ $bidding->name }}</h1>

        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-4">Description:</dt>
                    <dd class="col-sm-8">{{ $bidding->description }}</dd>

                    <dt class="col-sm-4">Starting Price:</dt>
                    <dd class="col-sm-8">{{ $bidding->starting_price }}</dd>

                    <dt class="col-sm-4">Start Date:</dt>
                    <dd class="col-sm-8">{{ $bidding->start_date->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">End Date:</dt>
                    <dd class="col-sm-8">{{ $bidding->end_date->format('M d, Y') }}</dd>

                    <dt class="col-sm-4">External Request ID:</dt>
                    <dd class="col-sm-8">{{ $bidding->external_request_id }}</dd>


                    <dt class="col-sm-4">Status:</dt>
                    <dd class="col-sm-8">
                        @if($bidding->open_for_bids)
                            <span class="badge badge-success">Open</span>
                        @else
                            <span class="badge badge-secondary">Closed</span>
                        @endif
                    </dd>
                </dl>

                @can('update', $bidding)
                    <a href="{{ route('app.procurement.biddings.edit', $bidding->id) }}" class="btn btn-warning">Edit</a>
                @endcan
                <a href="/procurement/biddings" class="btn btn-link">Back to List</a>
            </div>

            {{-- Image Display (if applicable)  --}}
            @if ($bidding->image)
                <div class="col-md-6">
                    <img src="{{ asset('images/' . $bidding->image) }}" alt="{{ $bidding->name }}" class="img-fluid">
                </div>
            @endif
        </div>
    </div>
@endsection

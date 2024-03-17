@extends('layouts/layoutMaster')

@section('content')
<div class="mt-4">
    <h2>Current Bids</h2>
    @if($procurementRequest->bids->count())
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Bidder</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($procurementRequest->bids as $bid)
                <tr>
                    <td class="px-4 py-2">{{ $bid->bidder_id }} (Placeholder)</td>
                    <td class="px-4 py-2">{{ $bid->price }}</td>
                    <td class="px-4 py-2">
                        <span class="{{ $bid->status == 'Selected' ? 'text-green-500' : 'text-gray-600' }}">
                             {{ $bid->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No bids submitted yet.</p>
    @endif
    @include('bidsshow', ['procurementRequest' => $procurementRequest])

</div>
@endsection

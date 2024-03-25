@extends('layouts.layoutMaster')

@section('title', $biddingProduct->name)

@section('content')
    <h1>Bidding Product: {{ $biddingProduct->name }}</h1>

    <h2>Bids</h2>

    <button type="button" onclick="showWinners()">Show Winners</button>

    @if ($biddingProduct->bids->count() > 0)
        <table class="bids-table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Bidder Type</th>
                    <th>Bidder Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($biddingProduct->bids as $bid)
                    <tr>
                        <td>{{ $bid->amount }}</td>
                        <td>{{ $bid->supplier ? 'Supplier' : 'Vendor' }}</td>
                        <td>
                            @if ($bid->supplier)
                                {{ $bid->supplier->supplier_name }}
                            @elseif($bid->vendor)
                                {{ $bid->vendor->vendor_name }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No bids have been placed for this product yet.</p>
    @endif

    <script>
        function showWinners() {
            const bidRows = document.querySelectorAll('.bids-table tbody tr');
            const bidsArray = Array.from(bidRows);

            bidsArray.sort((a, b) => {
                const amountA = parseFloat(a.querySelector('td:first-child').textContent);
                const amountB = parseFloat(b.querySelector('td:first-child').textContent);
                return amountA - amountB;
            });

            const bidsTbody = document.querySelector('.bids-table tbody');
            bidsTbody.innerHTML = '';
            bidsArray.forEach(bidRow => bidsTbody.appendChild(bidRow));
        }
    </script>
@endsection

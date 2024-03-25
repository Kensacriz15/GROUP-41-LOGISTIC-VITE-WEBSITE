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
                        <td>
            <button type="button" onclick="createInvoice({{ $bid->id }})">Create Invoice</button>
        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No bids have been placed for this product yet.</p>
    @endif

    @if ($biddingProduct->winners->count() > 0)
        <h2>Winners</h2>
        @foreach ($biddingProduct->winners as $winner)
            <div class="winner-card">
                <p><strong>Product:</strong> {{ $biddingProduct->name }}</p>
                <p><strong>Winning Bidder:</strong>
                @if ($winner->bid->supplier)
                    {{ $winner->bid->supplier->supplier_name}} (Supplier)
                @else
                    {{ $winner->bid->vendor->vendor_name}} (Vendor)
                @endif
                </p>
                <p><strong>Amount:</strong> {{ $winner->bid->amount }}</p>
                <button type="button" onclick="window.location.href='{{ route('createInvoice', ['bidId' => $bid->id]) }}'">Create Invoice</button>
            </div>
        @endforeach
    @endif

    <script>
        function showWinners() { /* ... your existing sorting code ... */ }
        function createInvoice(winnerId) { /* ...  Your invoice creation logic ... */ }
    </script>
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

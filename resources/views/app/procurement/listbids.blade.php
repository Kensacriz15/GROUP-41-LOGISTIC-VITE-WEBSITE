  @extends('layouts.layoutMaster')

  @section('title', $biddingProduct->name)

  @section('content')
      <h1>Bidding Product: {{ $biddingProduct->name }}</h1>

      <div class="row">
          <div class="col-md-6 mb-4">
              <div class="card">
                  <div class="card-header">Bids</div>
                  <div class="card-body">
                  <button type="button" class="btn btn-sm btn-success mb-2" style="float: right;" id="showLowestButton">Show Lowest</button>
                   @if ($biddingProduct->bids->count() > 0)
                          <table class="bids-table table table-striped table-bordered">
                              <thead>
                                  <tr>
                                      <th>ID</th>
                                      <th>Amount</th>
                                      <th>Bidder Type</th>
                                      <th>Bidder Name</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($biddingProduct->bids as $bid)
                                      <tr>
                                          <td>{{ $bid->id }}</td>
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
                  </div>
              </div>
          </div>
          <div class="col-md-6 mb-4">
              <div class="card">
                  <div class="card-header">Winners</div>
                  <div class="card-body">
                      @if ($biddingProduct->winners->count() > 0)
                          <table class="winners-table table table-striped table-bordered">
                              <thead>
                                  <tr>
                                      <th>Product</th>
                                      <th>Winning Bidder</th>
                                      <th>Amount</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @foreach ($biddingProduct->winners as $winner)
    <tr>
        <td>{{ $biddingProduct->name }}</td>
        <td>
            @if ($winner->bid && $winner->bid->supplier)
                {{ $winner->bid->supplier->supplier_name }} (Supplier)
            @elseif($winner->bid && $winner->bid->vendor)
                {{ $winner->bid->vendor->vendor_name }} (Vendor)
            @else
                N/A
            @endif
        </td>
        <td>{{ $winner->bid->amount }}</td>
        <td>
        <button type="button" onclick="createInvoiceWithPrompt()" class="btn btn-sm btn-warning mb-2">Create Invoice</button>
    </tr>
@endforeach
                              </tbody>
                          </table>
                      @endif
                  </div>
              </div>
          </div>
      </div>

      <style>
          .bids-table {
              width: 100%;
          }

          .bids-table th,
          .bids-table td {
              padding: 8px;
          }

          .winners-table {
              width: 100%;
          }

          .winners-table th,
          .winners-table td {
              padding: 8px;
          }
      </style>

      <script>
       document.addEventListener('DOMContentLoaded', function() {
    const showLowestButton = document.getElementById('showLowestButton');
    let isAscending = true; // Variable to track the sorting order
    showLowestButton.addEventListener('click', showLowestBids);

    function showLowestBids() {
        const bidRows = Array.from(document.querySelectorAll('.bids-table tbody tr'));
        bidRows.sort((a, b) => {
            const amountA = parseFloat(a.querySelector('td:nth-child(2)').textContent);
            const amountB = parseFloat(b.querySelector('td:nth-child(2)').textContent);
            if (isAscending) {
                return amountA - amountB; // Sort in ascending order
            } else {
                return amountB - amountA; // Sort in descending order
            }
        });
        const tbody = document.querySelector('.bids-table tbody');
        tbody.innerHTML = '';
        bidRows.forEach(row => tbody.appendChild(row));

        isAscending = !isAscending; // Toggle the sorting order
    }
});

          function createInvoiceWithPrompt() {
        const winnerId = prompt('Please enter the winner ID from the list:');
        if (winnerId) {
            window.location.href = '{{ url('invoice/create') }}/' + winnerId;
        }
    }
      </script>
  @endsection

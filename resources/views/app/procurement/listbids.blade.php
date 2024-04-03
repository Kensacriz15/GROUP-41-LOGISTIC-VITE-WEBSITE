  @extends('layouts.layoutMaster')

  @section('title', $biddingProduct->name)

  @section('content')
      <h1>Bidding Product: {{ $biddingProduct->name }}</h1>

      <div class="row">
          <div class="col-md-6 mb-4">
              <div class="card">
                  <div class="card-header">Bids</div>
                  <div class="card-body">
                  <button type="button" onclick="showLowestBids()" class="btn btn-sm btn-success mb-2" style="float: right;">Show Lowest</button>                    @if ($biddingProduct->bids->count() > 0)
                          <table class="bids-table table table-striped table-bordered">
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
                                              @if ($winner->bid->supplier)
                                                  {{ $winner->bid->supplier->supplier_name }} (Supplier)
                                              @else
                                                  {{ $winner->bid->vendor->vendor_name }} (Vendor)
                                              @endif
                                          </td>
                                          <td>{{ $winner->bid->amount }}</td>
                                          <td>
                                          <button type="button" onclick="window.location.href='{{ route('createInvoice', ['winnerId' => $winner->id]) }}'" class="btn btn-sm btn-warning mb-2">Create Invoice</button>
                                          </td>
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
          function showLowestBids() {
              const bidRows = Array.from(document.querySelectorAll('.bids-table tbody tr'));
              bidRows.sort((a, b) => {
                  const amountA = parseFloat(a.querySelector('td').textContent);
                  const amountB = parseFloat(b.querySelector('td').textContent);
                  return amountA - amountB;
              });
              const tbody = document.querySelector('.bids-table tbody');
              tbody.innerHTML = '';
              bidRows.forEach(row => tbody.appendChild(row));
          }

      </script>
  @endsection

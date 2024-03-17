@extends('layouts.layoutMaster')

@section('content')
    <h1>Open Procurement Requests</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($requests->isEmpty())
        <p>There are currently no open procurement requests.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Item(s)</th>
                    <th>Requester</th>
                    <th>Deadline</th>
                    <th>Submit Bid</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>
                            @php
                                $requestData = json_decode($request->request_data, true);
                            @endphp
                            @foreach($requestData['items'] as $item)
                                <p><strong>Item:</strong> {{ $item['name'] ?? 'N/A' }}</p>
                                <p><strong>Quantity:</strong> {{ $item['quantity'] ?? 'N/A' }}</p>
                            @endforeach
                        </td>
                        <td>
                            {{ $requestData['requester_info']['name'] ?? 'N/A'}} <br>
                            {{ $requestData['requester_info']['contact'] ?? 'N/A' }}
                        </td>
                        <td>{{ $request->deadline }}</td>
                        <td>
                            <a href="{{ route('submit_bid', ['requestId' => $request->id]) }}">Submit Bid</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $requests->links() }}
    @endif
@endsection

<!DOCTYPE html>
<html>
<head>
    <title>Procurement Request PDF</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
        }

        .card-body p {
            margin-bottom: 5px;
        }

        ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h1>Procurement Request #{{ $request->external_request_id }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Status:</strong> {{ $request->status }}</p>
            <p><strong>Department:</strong> {{ $request->department->name }}</p>
            <p><strong>Created At:</strong> {{ $request->created_at->format('m/d/Y') }}</p>

            <h5>Requester Information</h5>
            <p><strong>Name:</strong> {{ $request->request_data['requester_info']['name'] ?? 'Not Available' }}</p>
            <p>
            <strong>Contact:</strong><br>
Address: {{ $request->request_data['requester_info']['contact']['address'] ?? 'Not Available' }}<br>
Phone: {{ $request->request_data['requester_info']['contact']['phone'] ?? 'Not Available' }}

            <h5>Request Items</h5>
            <ul>
                @foreach ($request->request_data['items'] as $item)
                <li>
                    <strong>Product Name:</strong> {{ $item['product_name'] }} <br>
                    <strong>Description:</strong> {{ $item['description'] }} <br>
                    <strong>Quantity:</strong> {{ $item['quantity'] }}
                </li>
                @endforeach
            </ul>

            <h5>Justification</h5>
            <p>{{ $request->request_data['justification'] }}</p>
        </div>
    </div>
</body>
</html>

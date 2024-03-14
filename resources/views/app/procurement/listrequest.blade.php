@extends('layouts/layoutMaster')

@section('title', 'Procurement Request List')

@section('content')
<div class="container">
    <h1>Procurement Request List</h1>
    <div class="mb-3">
        <form action="{{ route('app.procurement.listrequest') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by ID, Status, or Department" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Department</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $request->department->name }}</td>
                    <td>{{ $request->created_at->format('m/d/Y') }}</td>
                    <td>
                        <a href="{{ route('app.procurement.listrequestshow', $request) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('app.procurement.pdf', ['id' => $request->id]) }}" target="_blank" class="btn btn-sm btn-success">PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

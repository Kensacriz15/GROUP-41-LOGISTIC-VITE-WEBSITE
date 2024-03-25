@extends('layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1>Biddings</h1>

        {{--  Add New Bidding Button (if applicable) --}}
        @if (Auth::check() && Auth::user()->can('create', App\Models\biddingproduct::class))
            <a href="{{ route('app.procurement.biddings.create') }}" class="btn btn-primary mb-3">Create New Bidding</a>
        @endif

        @if($biddings->count())
            <table class="table table-striped"> <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Starting Price</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($biddings as $bidding)
                        <tr>
                            <td>{{ $bidding->name }}</td>
                            <td>{{ Str::limit($bidding->description, 50) }} </td>
                            <td>{{ $bidding->starting_price }}</td>
                            <td>{{ $bidding->start_date->format('M d, Y') }}</td>
                            <td>{{ $bidding->end_date->format('M d, Y') }}</td>
                            <td>
                            @if($bidding->isOpen())
    <span class="badge badge-success">Open</span>
@else
    <span class="badge badge-secondary">Closed</span>
@endif
                            </td>
                            <td>
                                <a href="{{ route('app.procurement.biddings.show', $bidding->id) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('app.procurement.biddings.edit', $bidding->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                 @can('delete', $bidding)
                                    <form method="POST" action="{{ route('app.procurement.biddings.destroy', $bidding->id) }}" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No biddings found.</p>
        @endif
    </div>
@endsection

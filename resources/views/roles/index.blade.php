@extends('layouts/layoutMaster')

@section('title', 'Manage Roles')

@section('content')
<div class="card">
    <div class="card-header">Manage Roles</div>
    <div class="card-body">
        @if(Gate::allows('superAdminAccess'))
            <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Name</th>
                <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="3">
                        <span class="text-danger">
                            <strong>No Role Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mb-3 row mt-3">

    <!-- Custom Pagination UI -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item first">
                <a class="page-link" href="#"><i class="ti ti-chevrons-left ti-xs"></i></a>
            </li>
            <li class="page-item prev">
                <a class="page-link" href="#"><i class="ti ti-chevron-left ti-xs"></i></a>
            </li>
            @for ($i = 1; $i <= $roles->lastPage(); $i++)
                <li class="page-item {{ $i == $roles->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $roles->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item next">
                <a class="page-link" href="#"><i class="ti ti-chevron-right ti-xs"></i></a>
            </li>
            <li class="page-item last">
                <a class="page-link" href="#"><i class="ti ti-chevrons-right ti-xs"></i></a>
            </li>
        </ul>
    </nav>
</div>


                <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Role</a>

        <table class="table table-striped table-bordered">
            </table>
    </div>
</div>
@endsection

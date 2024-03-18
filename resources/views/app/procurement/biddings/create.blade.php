@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Bidding Product') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('app.procurement.biddings.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
    <div class="col-md-6">
        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="starting_price" class="col-md-4 col-form-label text-md-right">{{ __('Starting Price') }}</label>
    <div class="col-md-6">
        <input id="starting_price" type="number" step="0.01" class="form-control @error('starting_price') is-invalid @enderror" name="starting_price" value="{{ old('starting_price') }}" required autocomplete="starting_price">
        @error('starting_price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>
    <div class="col-md-6">
        <input id="start_date" type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required>
        @error('start_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>
    <div class="col-md-6">
        <input id="end_date" type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required>
        @error('end_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>`
<div>
    <label for="external_request_id">Procurement Request:</label>

    <select name="external_request_id">
        <option value="">--Select Procurement Request--</option>
        @foreach($procurementRequests as $request)
            <option value="{{ $request->id }}">
                {{ $request->external_request_id }}
            </option>
        @endforeach
    </select>
</div>
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image" required>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

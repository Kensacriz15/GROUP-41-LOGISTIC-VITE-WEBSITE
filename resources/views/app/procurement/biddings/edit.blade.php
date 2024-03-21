@extends('layouts/layoutMaster')

@section('title', 'Edit Bidding')

@section('content')
<div class="container">
  <h1>Edit Bidding: {{ $bidding->name }}</h1>

  <form method="POST" action="{{ route('app.procurement.biddings.update', $bidding->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $bidding->name) }}" required>
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="description">Description:</label>
      <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $bidding->description) }}</textarea>
      @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="starting_price">Starting Price:</label>
      <input type="number" step="0.01" class="form-control @error('starting_price') is-invalid @enderror" id="starting_price" name="starting_price" value="{{ old('starting_price', $bidding->starting_price) }}" required>
      @error('starting_price')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="image">Current Image: </label>
      @if ($bidding->image)
        <img src="{{ asset('images/' . $bidding->image) }}" alt="{{ $bidding->name }}" style="max-width: 200px;">
      @endif
      <label for="image">New Image (Optional):</label>
      <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
       @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="start_date">Start Date:</label>
      <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $bidding->start_date->format('Y-m-d')) }}" required>
      @error('start_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="end_date">End Date:</label>
      <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $bidding->end_date->format('Y-m-d')) }}" required>
      @error('end_date')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group">
      <label for="external_request_id">External Request ID:</label>
      <input type="text" class="form-control @error('external_request_id') is-invalid @enderror" id="external_request_id" name="external_request_id" value="{{ old('external_request_id', $bidding->external_request_id) }}">
      @error('external_request_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update Bidding</button>
    <a href="{{ route('app.procurement.biddings.index') }}" class="btn btn-link">Back to List</a>
  </form>
</div>
@endsection

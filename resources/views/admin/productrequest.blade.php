@extends('admin.layouts.master')
@push('otherstyle')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/panzoom.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
@endpush
@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">All Product Requests</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Product Image</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phonenumber</th>
              <th>Message</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $r)
            <tr>
              <td class="text-center">
                <img data-fancybox src="{{ asset("uploads/{$r->image}") }}" alt="Receipt" role="button" height="25">
              </td>
              <td>{{ $r->name }}</td>
              <td>{{ $r->email }}</td>
              <td>{{ $r->phonenumber }}</td>
              <td>{{ $r->message }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('otherscript')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
@endpush
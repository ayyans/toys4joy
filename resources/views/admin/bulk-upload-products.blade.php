@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Bulk Upload Products</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.store-bulk-upload-products') }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">
            <input type="file" name="file" id="file">
            <button type="submit" class="btn btn-sm btn-outline-primary">Bulk Upload</button>
          </form>
          @if ( session()->has('failures') )
            <hr>
            <h4>Failure Logs</h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Row</th>
                  <th>Column</th>
                  <th>Error</th>
                </tr>
              </thead>
              <tbody>
                @foreach (session('failures') as $failure)
                <tr>
                  <td>{{ $failure->row() }}</td>
                  <td>{{ $failure->attribute() }}</td>
                  <td>{{ implode(', ', $failure->errors()) }}</td>
                  <td></td>
                </tr>
                {{-- $failure->values(); // The values of the row that has failed. --}}
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
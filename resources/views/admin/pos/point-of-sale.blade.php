@extends('admin.layouts.master')
@push('otherstyle')
  @livewireStyles
@endpush
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="row">
    <div class="col">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Point of Sale</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              @livewire('pos.show')
            </div>
            <div class="col">
              @livewire('pos.products')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('otherscript')
  @livewireScripts
@endpush
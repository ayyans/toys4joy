@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            Add Third Party Order
        </div>
        <div class="card-body">
            <form action="{{ route('admin.third-party-orders.store') }}" method="post">
                @csrf
                @include('admin.third-party-orders.form')
                <button type="btn" class="btn btn-success">Add Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
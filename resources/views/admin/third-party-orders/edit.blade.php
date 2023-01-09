@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            Update Third Party Order
        </div>
        <div class="card-body">
            <form action="{{ route('admin.third-party-orders.update', $thirdPartyOrder->id) }}" method="post">
                @csrf
                @method('put')
                @include('admin.third-party-orders.form')
                <button type="btn" class="btn btn-success">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
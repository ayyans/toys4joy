@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-end">
            <a href="{{route('admin.bulk-upload-products')}}" class="btn btn-round btn-primary mr-2">Bulk Upload Product</a>
            <a href="{{route('admin.addproducts')}}" class="btn btn-round btn-success">Add Product</a>
        </div>
    </div>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Products</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>SKU</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>New Arrival</th>
                            <th>Best Seller</th>
                            <th>Best Offer</th>
                            <th>price</th>
                            <th>discount</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->brand->brand_name }}</td>
                            <td>
                                <input type="checkbox" data-url="{{ route('admin.changeProductFeaturedType', ['product' => $product->id, 'type' => 'new_arrival']) }}" data-id="{{ $product->id }}" class="featured_type_checkbox" {{ $product->new_arrival ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox" data-url="{{ route('admin.changeProductFeaturedType', ['product' => $product->id, 'type' => 'best_seller']) }}" data-id="{{ $product->id }}" class="featured_type_checkbox" {{ $product->best_seller ? 'checked' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox" data-url="{{ route('admin.changeProductFeaturedType', ['product' => $product->id, 'type' => 'best_offer']) }}" data-id="{{ $product->id }}" class="featured_type_checkbox" {{ $product->best_offer ? 'checked' : '' }}>
                            </td>
                            <td>{{$product->unit_price}}</td>
                            <td>{{$product->discount}}</td>
                            <td>{{$product->qty}}</td>
                            <td>
                                @if($product->status==1)
                                <div class="badge badge-danger">not active</div>
                                @elseif($product->status==2)
                                <div class="badge badge-success">Active</div>
                                @endif

                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark">Info</button>
                                    <button type="button" class="btn btn-success dropdown-toggle"
                                        data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ route('website.productDetails', $product->url) }}" class="dropdown-item" target="_blank">View</a></li>
                                        @if($product->status==1)

                                        <li><a href="{{route('admin.activateProd',[encrypt($product->id)])}}"
                                                class="dropdown-item">Activate</a></li>
                                        @elseif($product->status==2)
                                        <li><a href="{{route('admin.deactivateprod',[encrypt($product->id)])}}"
                                                class="dropdown-item">Deactivate</a></li>
                                        @endif
                                        <li><a href="{{route('admin.editproducts',[encrypt($product->id)])}}"
                                                class="dropdown-item">Edit</a></li>

                                        <li><a href="{{route('admin.deleteprod',[encrypt($product->id)])}}"
                                                class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> --}}

                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>New Arrival</th>
                            <th>Best Seller</th>
                            <th>Best Offer</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('otherscript')
    <script>
        // datatables
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [[ 0, 'desc' ]],
            ajax: "{{ route('admin.getProducts') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'sku', name: 'sku'},
                {data: 'barcode', name: 'barcode'},
                {data: 'title', name: 'title'},
                {data: 'brand', name: 'brand'},
                {data: 'new_arrival', name: 'new_arrival'},
                {data: 'best_seller', name: 'best_seller'},
                {data: 'best_offer', name: 'best_offer'},
                {data: 'unit_price', name: 'unit_price'},
                {data: 'discount', name: 'discount'},
                {data: 'qty', name: 'qty'},
                {data: 'status', name: 'status'},
                {data: 'actions', name: 'actions'},
            ]
        });

        // featured functionality
        $(function() {
            $('.dataTable').on('click', '.featured_type_checkbox', function() {
                const url = $(this).data('url');
                const id = $(this).data('id');
                const status = $(this).is(':checked');
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status })
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        toastr.success(`Product #${id} featured type changed!`);
                    } else {
                        toastr.error(`Error in changing Product #${id} featured type!`);
                    }
                });
            });
        });

        // toggle status functionality
        $('.datatable').on('init.dt', function() {
            $('.switch-toggle').bootstrapToggle()
                .on('change', function() {
                    const url = $(this).data('url');
                    const id = $(this).data('id');
                    const status = $(this).is(':checked') ? 2 : 1;
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status) {
                            toastr.success(`Product #${id} status changed!`);
                        } else {
                            toastr.error(`Error in changing Product #${id} status!`);
                        }
                    });
                });
        });
    </script>
@endpush
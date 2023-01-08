 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.dashboard')}}">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Toy4Joy</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{route('admin.dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">


<li class="nav-item">
    <a class="nav-link" href="{{route('admin.bulkupload')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Bulk Upload</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#localPointOfSale"
        aria-expanded="true" aria-controls="localPointOfSale">
        <i class="fas fa-fw fa-globe"></i>
        <span>Local POS</span>
    </a>
    <div id="localPointOfSale" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.local.pos.point-of-sale') }}">Point of Sale</a>
            {{-- <a class="collapse-item" href="{{ route('admin.pos.sales-report') }}">Sales Report</a>
            <a class="collapse-item" href="{{ route('admin.pos.refund-report') }}">Refund Report</a>
            <a class="collapse-item" href="{{ route('admin.pos.items-sold-report') }}">Items Sold Report</a> --}}
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pointOfSale"
        aria-expanded="true" aria-controls="pointOfSale">
        <i class="fas fa-fw fa-desktop"></i>
        <span>POS</span>
    </a>
    <div id="pointOfSale" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.pos.point-of-sale') }}">Point of Sale</a>
            <a class="collapse-item" href="{{ route('admin.pos.sales-report') }}">Sales Report</a>
            <a class="collapse-item" href="{{ route('admin.pos.refund-report') }}">Refund Report</a>
            <a class="collapse-item" href="{{ route('admin.pos.items-sold-report') }}">Items Sold Report</a>
        </div>
    </div>
</li>
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Pages Collapse Menu -->


<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-user"></i>
        <span>Customers</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.customer')}}">Customers</a>
           
        </div>
    </div>
</li>



<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryUtility"
        aria-expanded="true" aria-controls="categoryUtility">
        <i class="fas fa-fw fa-list"></i>
        <span>Categories</span>
    </a>
    <div id="categoryUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.categories')}}">Category</a>
            <a class="collapse-item" href="{{route('admin.subcategories')}}">Subcategory</a>
            
        </div>
    </div>
</li>
<hr class="sidebar-divider">


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandsUtility"
        aria-expanded="true" aria-controls="brandsUtility">
        <i class="fas fa-fw fa-list"></i>
        <span>Brands</span>
    </a>
    <div id="brandsUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.brands')}}">Add Brands</a>
            <a class="collapse-item" href="{{route('admin.brands')}}">List Brands</a>
            
        </div>
    </div>
</li>
<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productUtility"
        aria-expanded="true" aria-controls="productUtility">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Products</span>
    </a>
    <div id="productUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">      
          
            <a class="collapse-item" href="{{route('admin.addproducts')}}">Add products</a>
            <a class="collapse-item" href="{{route('admin.products')}}">List of products</a>
            {{-- <a class="collapse-item" href="{{route('admin.atribute')}}">Attribute</a> --}}
        </div>
    </div>
</li>

<hr class="sidebar-divider my-0">

@php
    $order = DB::table('orders')->whereNotNull('user_id')->where('is_wishlist', false)->where('additional_details->is_new', true)->count();
    $guestorder = DB::table('orders')->whereNull('user_id')->where('additional_details->is_new', true)->count();
    $wishlistorder = DB::table('orders')->whereNotNull('user_id')->where('is_wishlist', true)->where('additional_details->is_new', true)->count();
    $totalordernumbers = $order + $guestorder + $wishlistorder;
@endphp
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ordersUtility"
        aria-expanded="true" aria-controls="ordersUtility">
        <i class="fas fa-fw fa-shopping-bag"></i>
        <span>Orders @if($totalordernumbers > 0) <span style="margin-left: 50px;padding: 4px 7px;" class="badge badge-danger">{{ $totalordernumbers }}</span>@endif</span>    
    </a>
    <div id="ordersUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('admin.abandonedOrders')}}">Abandoned Orders</a>
            {{-- <a class="collapse-item" href="{{route('admin.guestOrders')}}">Guest Orders @if($guestorder > 0) <span style="padding: 4px 7px;margin-left: 30px;" class="badge badge-danger">{{ $guestorder }}</span>@endif</a> --}}
            <a class="collapse-item" href="{{route('admin.custOrders')}}">Orders @if($order > 0) <span style="padding: 4px 7px;margin-left: 30px;" class="badge badge-danger">{{ $order }}</span>@endif</a>
            <a class="collapse-item" href="{{route('admin.wishlistorders')}}">Wishlist Orders @if($wishlistorder > 0) <span style="padding: 4px 7px;margin-left: 30px;" class="badge badge-danger">{{ $wishlistorder }}</span>@endif</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#returnUtility"
        aria-expanded="true" aria-controls="returnUtility">
        <i class="fa fa-arrow-left"></i>
        <span>Requests</span>
    </a>
    <div id="returnUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{route('admin.return-requests.index')}}">Return Requests</a>
            <a class="collapse-item" href="{{route('admin.productrequest')}}">Product Requests</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#couponsUtility"
        aria-expanded="true" aria-controls="couponsUtility">
        <i class="fas fa-fw fa-shopping-bag"></i>
        <span>Coupons</span>
    </a>
    <div id="couponsUtility" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.coupon')}}">Coupon List</a>
           
        </div>
    </div>
</li>
<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#giftcards"
        aria-expanded="true" aria-controls="giftcards">
        <i class="fas fa-fw fa-shopping-bag"></i>
        <span>Gift Cards</span>
    </a>
    <div id="giftcards" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.giftcards')}}">Gift Cards</a>
           
        </div>
    </div>
</li>
<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#points"
        aria-expanded="true" aria-controls="points">
        <i class="fas fa-fw fa-coins"></i>
        <span>Points</span>
    </a>
    <div id="points" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.points')}}">Points List</a>
           
        </div>
    </div>
</li>

<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#sitesettigns"
        aria-expanded="true" aria-controls="sitesettigns">
        <i class="fas fa-fw fa-shopping-bag"></i>
        <span>Site Settings</span>
    </a>
    <div id="sitesettigns" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{route('admin.settings.index')}}">General Settings</a>
            <a class="collapse-item" href="{{route('admin.homepagebanners')}}">Homepage Banners</a>
            <a class="collapse-item" href="{{route('admin.smssettings')}}">SMS Settings</a>
        </div>
    </div>
</li>
<!-- <hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaction"
        aria-expanded="true" aria-controls="transaction">
        <i class="fas fa-fw fa-dollar-sign"></i>
        <span>Transaction</span>
    </a>
    <div id="transaction" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="javascript:void(0)">Category</a>
            <a class="collapse-item" href="javascript:void(0)">Subcategory</a>
            <a class="collapse-item" href="javascript:void(0)">Add products</a>
            <a class="collapse-item" href="javascript:void(0)">List of products</a>
        </div>
    </div>
</li> -->

<hr class="sidebar-divider">

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reports"
        aria-expanded="true" aria-controls="reports">
        <i class="fas fa-fw fa-dollar-sign"></i>
        <span>Reports</span>
    </a>
    <div id="reports" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">           
            <a class="collapse-item" href="{{ route('admin.report.sales') }}">Sales Report</a>
            <a class="collapse-item" href="{{ route('admin.report.inventory') }}">Inventory Report</a>
            <a class="collapse-item" href="{{ route('admin.report.customers') }}">Customers Report</a>
            <a class="collapse-item" href="{{ route('admin.report.guests') }}">Guests Report</a>
            <a class="collapse-item" href="{{ route('admin.report.generatedGiftCards') }}">Generated GC Report</a>
            <a class="collapse-item" href="{{ route('admin.report.usedGiftCards') }}">Used GC Report</a>
            <a class="collapse-item" href="{{ route('admin.report.returnedOrders') }}">Returned Orders Report</a>
            <a class="collapse-item" href="{{ route('admin.report.returnedOrderItems') }}">Returned Items Report</a>
            <a class="collapse-item" href="{{ route('admin.report.abandonedOrdersReport') }}">Abandoned Orders Report</a>
            <a class="collapse-item" href="{{ route('admin.report.coupons') }}">Coupons Report</a>
        </div>
    </div>
</li>

<hr class="sidebar-divider">


<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->
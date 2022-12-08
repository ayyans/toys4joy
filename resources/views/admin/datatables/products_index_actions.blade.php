<div class="btn-group">
  <button type="button" class="btn btn-dark">Info</button>
  <button type="button" class="btn btn-success dropdown-toggle"
      data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
      <li><a href="{{ route('website.productDetails', $url) }}" class="dropdown-item" target="_blank">View</a></li>
      {{-- @if($status==1)

      <li><a href="{{route('admin.activateProd',[encrypt($id)])}}"
              class="dropdown-item">Activate</a></li>
      @elseif($status==2)
      <li><a href="{{route('admin.deactivateprod',[encrypt($id)])}}"
              class="dropdown-item">Deactivate</a></li>
      @endif --}}
      <li><a href="{{route('admin.editproducts',[encrypt($id)])}}"
              class="dropdown-item">Edit</a></li>

      <li><a href="{{route('admin.deleteprod',[encrypt($id)])}}"
              class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a></li>
  </ul>
</div>
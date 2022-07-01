  
 <!-- Topbar Search -->
 



  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

<!-- Nav Item - Search Dropdown (Visible Only XS) -->






<div class="topbar-divider d-none d-sm-block"></div>

<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
        <img class="img-profile rounded-circle"
            src="{{asset('dashboard/img/undraw_profile.svg')}}">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <a class="dropdown-item" href="#">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
        </a>
        <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('admin.logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"role="button" >
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
    </div>
</li>

</ul>

</nav>
<!-- End of Topbar -->
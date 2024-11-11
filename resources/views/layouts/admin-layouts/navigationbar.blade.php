
<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse position-fixed">
            <h2 class="mt-3">
                <img src="{{ asset('image/logo.png') }}" alt="Agency logo" width="60px">
                SriLankaTours
            </h2>
            <pre>Admin Panel</pre>
            <div class="position-sticky">
                <ul class="nav flex-column SideMenuPosition">
                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page" href="{{route('admin.home')}}">
                            <img src="{{ asset('image/help-tools/dashboard.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Dashboard 
                        </a>
                    </li>
                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/setting') ? 'active' : '' }}" href="{{route('admin.setting')}}"> 
                            <img src="{{ asset('image/help-tools/setting.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Settings
                        </a>
                    </li>
                    <li class="nav-item list-bg ">
                        <a class="nav-link font-style {{ request()->is('admin/manageUsers') ? 'active' : '' }}" href="{{route('admin.manageUsers')}}">
                            <img src="{{ asset('image/help-tools/manage-users.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Manage Users
                        </a>
                    </li>

                    <hr class="border border-2 opacity-100">

                    <li class="nav-item list-bg ">
                        <a class="nav-link font-style {{ request()->is('admin/Booking') ? 'active' : '' }}" href="{{route('admin.booking')}}">
                            <img src="{{ asset('image/help-tools/booking.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Bookings
                        </a>
                    </li>
                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/message') ? 'active' : '' }}" href="{{route('admin.message')}}">
                            <img src="{{ asset('image/help-tools/messages.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Messages
                        </a>
                    </li>
                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/review') ? 'active' : '' }}" href="{{route('admin.review')}}">
                            <img src="{{ asset('image/help-tools/Reviews.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Reviews
                        </a>
                    </li>

                    <hr class="border border-2 opacity-100">

                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/showPackage') ? 'active' : '' }}" href="{{route('admin.travelPackage.show')}}">
                            <img src="{{ asset('image/help-tools/add-packages.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Travel Packages
                        </a>
                    </li>
                    <li class="nav-item list-bg">
                        <a class="nav-link font-style {{ request()->is('admin/addBlog') ? 'active' : '' }}" href="{{route('admin.addBlog')}}">
                            <img src="{{ asset('image/help-tools/add-blog-post.png') }}" class="dashbord-icon" alt="dashbord-icon">   
                            Blog Posts
                        </a>
                    </li>

                    <hr class="border border-2 opacity-100">
                    
                    <li class="nav-item" style="margin-top: 2px; font-weight: bolder;">
                         <!-- Authentication -->
                         <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <img src="{{ asset('image/help-tools/log-out.png') }}" class="dashbord-icon position-absolute ms-3" alt="dashbord-icon">
                            <button type="submit" class="btn nav-link ms-5">{{ __('Log Out') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

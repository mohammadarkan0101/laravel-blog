<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-white elevation-1">
    <!-- Brand Logo -->
    <div class="brand-link d-flex align-items-center">
        <img src="#" alt="Brand Logo" class="brand-image">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </div>
    <!-- Sidebar -->
    <div class="sidebar mt-3">
        <!-- Sidebar Menu -->
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <!-- Profile -->
                <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-person"></i>
                    <p>Profile</p>
                </a>
            </li>
            @role('editor')
                <li class="nav-item">
                    <!-- Data Blogs -->
                    <a href="{{ route('blogs.index') }}" class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Data Blogs</p>
                    </a>
                </li>
            @endrole
            @role('administrator')
                <li class="nav-item">
                    <!-- Data Users -->
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Data Users</p>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</aside>
<!-- /.Sidebar -->

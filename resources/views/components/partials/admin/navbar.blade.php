<!-- Left Navbar Links -->
<ul class="navbar-nav d-flex align-items-center">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" role="button">
            <i class="fas fa-bars"></i>
        </a>
    </li>

    <li class="nav-item d-none d-sm-inline-block ml-2">
        <p class="text-muted mb-0">
            Aplikasi Blog Sederhana Dengan Laravel
        </p>
    </li>
</ul>

<!-- Right Navbar Links -->
<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <!-- User Avatar / Dropdown Trigger -->
        <a href="#" class="nav-link p-0" data-toggle="dropdown">
            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center initials">
                {{ auth()->user()->initials() }}
            </div>
        </a>

        <!-- User Dropdown Menu -->
        <div class="dropdown-menu dropdown-menu-right">
            <!-- User Information -->
            <div class="dropdown-item-text">
                <strong>{{ auth()->user()->name }}</strong><br>
                <small>{{ auth()->user()->email }}</small>
            </div>

            <div class="dropdown-divider"></div>

            <!-- Profile -->
            <a href="{{ route('profile.index') }}" class="dropdown-item">
                <i class="bi bi-person mr-2"></i>
                Profile
            </a>

            <div class="dropdown-divider"></div>

            <!-- Logout -->
            <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right mr-2"></i>
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</ul>

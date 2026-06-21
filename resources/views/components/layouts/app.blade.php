<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<!-- Header -->
@include('components.partials.admin.header')

<body class="hold-transition">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('components.partials.admin.navbar')
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-1">
            @include('components.partials.admin.sidebar')
        </aside>

        <!-- Main Content -->
        <main class="content-wrapper">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            @include('components.partials.admin.footer')
        </footer>
    </div>

    @include('components.partials.admin.script')

    @stack('scripts')
</body>

</html>

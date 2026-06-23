<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<!-- Header -->
@include('components.partials.admin.header')

<body class="hold-transition">
    <div class="wrapper">
        <!-- Navbar -->
        @include('components.partials.admin.navbar')

        <!-- Sidebar -->
        @include('components.partials.admin.sidebar')

        <!-- Main Content -->
        <main class="content-wrapper">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('components.partials.admin.footer')
    </div>

    @include('components.partials.admin.script')
    
    @stack('scripts')
</body>

</html>
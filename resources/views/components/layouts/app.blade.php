<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

@include('components.partials.admin.header')

<body class="hold-transition">
    <div class="wrapper">

        @include('components.partials.admin.navbar')
        @include('components.partials.admin.sidebar')

        <div class="content-wrapper">
            {{ $slot }}
        </div>

        @include('components.partials.admin.footer')
    </div>

    @include('components.partials.admin.script')

    @stack('scripts')
</body>

</html>

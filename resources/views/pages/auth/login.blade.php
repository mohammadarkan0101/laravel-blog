<x-layouts.auth title="Halaman Login">

    <header class="mb-3">
        <h4 class="font-weight-bold">👋 Selamat Datang</h4>
        <p class="text-muted mb-0">
            Silakan login menggunakan email dan password Anda.
        </p>
    </header>

    @if (session('success'))
        <x-bootstrap.alert type="success" :message="session('success')" />
    @elseif (session('failed'))
        <x-bootstrap.alert type="danger" :message="session('failed')" />
    @endif

    <form action="{{ route('handle.login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <div class="input-group">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@email.com" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="font-weight-bold">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">
                    Remember me
                </label>
            </div>
            <a href="{{ route('password.request') }}" class="small">
                Forgot Password?
            </a>
        </div>

        <button type="submit" class="btn btn-primary btn-block mb-2">
            <i class="bi bi-box-arrow-in-right mr-1"></i> Login
        </button>

    </form>

    <form action="{{ url('oauth/google') }}" method="GET">
        <button type="submit" class="btn btn-danger btn-block d-flex justify-content-center align-items-center">
            <img src="{{ asset('assets/img/google-logo.webp') }}" alt="Google" width="18" height="18">
            <span class="ml-2">Continue with Google</span>
        </button>
    </form>

    <div class="text-center mt-3">
        <span class="text-muted">Belum punya akun?</span>
        <a href="{{ route('register') }}" class="font-weight-bold">
            Buat Akun..
        </a>
    </div>

</x-layouts.auth>
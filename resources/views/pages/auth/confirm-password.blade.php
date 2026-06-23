<x-layouts.auth title="Konfirmasi password">

    <header class="mb-3">
        <h4 class="font-weight-bold">🛡️ Konfirmasi password</h4>
        <p class="text-muted mb-0">
            Demi keamanan, silakan konfirmasi password Anda sebelum melanjutkan.
        </p>
    </header>

    <form action="{{ route('password.confirm') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="password" class="font-weight-bold">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password Anda" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-check-circle mr-1"></i> Konfirmasi password
        </button>

        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-muted small">
                    Lupa password?
                </a>
            </div>
        @endif

    </form>

</x-layouts.auth>
<x-layouts.auth title="Reset password">

    <header class="mb-3">
        <h4 class="font-weight-bold">🔄 Reset password</h4>
        <p class="text-muted mb-0">
            Masukkan password baru untuk akun Anda.
        </p>
    </header>

    @if (session('status'))
        <x-bootstrap.alert type="success" :message="session('status')" />
    @endif

    <form action="{{ route('password.store') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <div class="input-group">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email ?? '') }}" placeholder="Masukkan email" required readonly>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="font-weight-bold">Password baru</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password baru" required>
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

        <div class="form-group">
            <label for="password-confirm" class="font-weight-bold">Konfirmasi password baru</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Ulangi password baru" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-arrow-repeat mr-1"></i> Reset password
        </button>

    </form>

</x-layouts.auth>

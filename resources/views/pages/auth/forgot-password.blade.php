<x-layouts.auth title="Lupa password">

    <header class="mb-3">
        <h4 class="font-weight-bold">🔒 Lupa password</h4>
        <p class="text-muted mb-0">
            Masukkan email Anda untuk menerima tautan reset password.
        </p>
    </header>

    @if (session('status'))
        <x-bootstrap.alert type="success" :message="session('status')" />
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <div class="input-group">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email" required>
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

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-send mr-1"></i> Kirim Link Reset
        </button>

        <a href="{{ route('login') }}" class="btn btn-light w-100 mt-2">
            <i class="bi bi-arrow-left mr-1"></i> Kembali
        </a>

    </form>

</x-layouts.auth>

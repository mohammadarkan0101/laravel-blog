<x-layouts.auth title="Halaman Register">

    <header class="mb-3">
        <h4 class="font-weight-bold">✨ Registrasi</h4>
        <p class="text-muted mb-0">
            Silakan lengkapi data berikut untuk proses pendaftaran akun baru.
        </p>
    </header>

    <form action="{{ route('handle.register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name" class="font-weight-bold">Nama</label>
            <div class="input-group">
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                </div>
            </div>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <div class="input-group">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="example@email.com" value="{{ old('email') }}" required>
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
            <label for="phone" class="font-weight-bold">Nomor Telepon</label>
            <div class="input-group">
                <input type="number" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-telephone"></i>
                    </span>
                </div>
            </div>
            @error('phone')
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

        <div class="form-group">
            <label for="password_confirmation" class="font-weight-bold">Konfirmasi password</label>
            <div class="input-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Konfirmasi password" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                </div>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="bi bi-box-arrow-in-right mr-1"></i> Register
        </button>

        <div class="text-center mt-3">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="font-weight-bold">
                Login..
            </a>
        </div>

    </form>

</x-layouts.auth>
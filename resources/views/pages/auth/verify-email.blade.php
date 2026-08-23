<x-layouts.auth title="Verifikasi Email">

    <header class="mb-4">
        <h4 class="font-weight-bold">📧 Verifikasi Kode OTP</h4>
        <p class="text-muted mb-0">
            Terima kasih telah mendaftar. Silakan masukkan <strong>6 digit kode OTP</strong> yang telah kami kirimkan ke alamat email Anda.
        </p>
    </header>

    @if (session('status') == 'verification-link-sent' || session('message'))
        <x-bootstrap.alert type="success" :message="session('status') == 'verification-link-sent' ? 'Kode OTP baru telah dikirim ke email Anda.' : session('message')" />
    @endif

    <form action="{{ route('verify.otp') }}" method="POST" class="mb-4">
        @csrf

        <input type="hidden" name="email" value="{{ auth()->user()?->email }}">

        <div class="form-group mb-3">
            <label for="otp" class="font-weight-bold mb-2">Masukkan Kode OTP</label>
            <input type="text" name="otp" id="otp" class="form-control form-control-lg text-center @error('otp') is-invalid @enderror" placeholder="******" maxlength="6" required style="letter-spacing: 8px; font-size: 24px; font-weight: bold;">

            @error('otp')
                <div class="invalid-feedback text-start mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="bi bi-shield-check mr-1"></i> Verifikasi OTP
        </button>
    </form>

    <hr class="text-muted my-3">

    <p class="mb-2 text-muted text-center" style="font-size: 14px;">
        Tidak menerima kode? Pastikan cek folder Spam.
    </p>

    <form action="{{ route('resend.otp') }}" method="POST">
        @csrf

        <input type="hidden" name="email" value="{{ auth()->user()?->email }}">

        <button type="submit" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-clockwise mr-1"></i> Kirim Ulang Kode OTP
        </button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn btn-light w-100 mt-2">
            <i class="bi bi-box-arrow-right mr-1"></i> Logout
        </button>
    </form>

</x-layouts.auth>
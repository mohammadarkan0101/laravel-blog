<x-layouts.auth title="Verifikasi Email">

    <header class="mb-3">
        <h4 class="font-weight-bold">📧 Verifikasi Email</h4>
        <p class="text-muted mb-0">
            Terima kasih telah mendaftar. Sebelum melanjutkan, silakan verifikasi alamat email Anda
            dengan mengklik tautan yang telah kami kirimkan.
        </p>
    </header>

    @if (session('status') == 'verification-link-sent')
        <x-bootstrap.alert type="success" message="Link verifikasi baru telah dikirim ke alamat email Anda." />
    @endif

    <p class="mb-3">
        Jika Anda tidak menerima email verifikasi, klik tombol di bawah ini untuk
        mengirim ulang.
    </p>

    <form action="{{ route('verification.store') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right mr-1"></i> Kirim Ulang Email Verifikasi
        </button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-light w-100 mt-2">
            <i class="bi bi-box-arrow-right mr-1"></i> Logout
        </button>
    </form>

</x-layouts.auth>

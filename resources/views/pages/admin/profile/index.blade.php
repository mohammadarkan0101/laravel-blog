<x-layouts.app title="Profile">

    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Profile
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT SECTION -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- FLASH MESSAGES -->
                    @if (session('success'))
                        <x-bootstrap.alert type="success" :message="session('success')" />
                    @endif

                    <!-- UPDATE PROFILE -->
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3 d-flex flex-column">
                                <span class="font-weight-bold mb-1" style="font-size: 1.2rem;">
                                    Informasi Profile
                                </span>

                                <span class="text-muted" style="font-size: 0.9rem;">
                                    Perbarui informasi profile akun dan alamat email Anda.
                                </span>
                            </div>

                            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <!-- PREVIEW IMAGE -->
                                <img id="previewImage" 
                                     src="{{ $user->image ? asset('storage/users/' . $user->image) : asset('assets/img/default-profile.webp') }}" 
                                     data-default="{{ asset('assets/img/default-profile.webp') }}"
                                     class="img-fluid img-thumbnail img-user mb-3"
                                >

                                <!-- INPUT FILE IMAGE -->
                                <input type="file" id="image" name="image" class="d-none" accept=".png,.jpg,.jpeg">

                                <!-- INPUT REMOVE IMAGE -->
                                <input type="hidden" id="removeImage" name="removeImage" value="0">

                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="mb-3">
                                    <button type="button" class="btn btn-default" onclick="document.getElementById('image').click();">
                                        PILIH PHOTO
                                    </button>

                                    <button type="button" id="btnRemoveImage" class="btn btn-default ml-1">
                                        HAPUS PHOTO
                                    </button>
                                </div>

                                <!-- NAMA LENGKAP -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ALAMAT EMAIL -->
                                <div class="mb-3">
                                    <label for="email" class="form-label mb-0">Alamat Email</label>
                                    <small class="text-muted d-block mb-1" style="font-size: 0.9rem;">
                                        Jika email diubah, Anda harus verifikasi ulang email tersebut.
                                    </small>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- NOMOR TELEPON -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ROLE USER -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role User</label>
                                    <input type="text" id="role" name="role" class="form-control" value="{{ $user->role }}" required readonly>
                                </div>

                                <button type="reset" class="btn btn-default mr-1">
                                    <i class="bi bi-x-circle"></i> Reset
                                </button>

                                <button type="submit" class="btn btn-default">
                                    <i class="bi bi-save"></i> Update
                                </button>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- UPDATE PASSWORD -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">

                            <div class="mb-3 d-flex flex-column">
                                <span class="font-weight-bold mb-1" style="font-size: 1.2rem;">
                                    Perbarui Kata Sandi
                                </span>

                                <span class="text-muted" style="font-size: 0.9rem;">
                                    Gunakan kata sandi yang panjang dan acak agar tetap aman.
                                </span>
                            </div>

                            <form action="{{ route('update.password') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!-- PASSWORD LAMA -->
                                <div class="mb-3">
                                    <label for="old_password" class="form-label">Password Lama</label>
                                    <input type="password" id="old_password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" required>
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- PASSWORD BARU -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- KONFIRMASI PASSWORD -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="reset" class="btn btn-default mr-1">
                                    <i class="bi bi-x-circle"></i> Reset
                                </button>

                                <button type="submit" class="btn btn-default">
                                    <i class="bi bi-save"></i> Update
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const imageInput = document.getElementById("image");
                const removeInput = document.getElementById("removeImage");
                const previewImage = document.getElementById("previewImage");
                const removeButton = document.getElementById("btnRemoveImage");
                const form = imageInput.closest("form");

                if (!form || !imageInput || !removeInput || !previewImage || !removeButton) return;

                const originalImageSrc = previewImage.src;
                const defaultImageSrc = previewImage.dataset.default;
                const initialRemove = removeInput.value;

                let objectUrl = null;

                function cleanup() {
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                        objectUrl = null;
                    }
                }

                imageInput.addEventListener("change", (e) => {
                    const file = e.target.files[0];
                    if (!file) return;

                    cleanup();

                    objectUrl = URL.createObjectURL(file);
                    previewImage.src = objectUrl;
                    removeInput.value = "0";
                });

                removeButton.addEventListener("click", () => {
                    cleanup();

                    previewImage.src = defaultImageSrc;
                    imageInput.value = "";
                    removeInput.value = "1";
                });

                form.addEventListener("reset", () => {
                    setTimeout(() => {
                        cleanup();

                        previewImage.src = originalImageSrc;
                        imageInput.value = "";
                        removeInput.value = initialRemove;
                    }, 0);
                });
                
                window.addEventListener("beforeunload", cleanup);
            });
        </script>
    @endpush

</x-layouts.app>

<x-layouts.app title="Edit Akun">

    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Akun</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Edit Akun
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
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <!-- NAMA LENGKAP -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ALAMAT EMAIL -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- NOMOR TELEPON -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="number" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- PASSWORD BARU -->
                                <div class="mb-3">
                                    <label for="password" class="form-label mb-0">Password Baru</label>
                                    <small class="form-text text-danger d-block mb-2">
                                        (Kosongkan jika tidak ingin diubah)
                                    </small>
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="password baru">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- KONFIRMASI PASSWORD -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label mb-0">Konfirmasi Password</label>
                                    <small class="form-text text-danger d-block mb-2">
                                        (Kosongkan jika tidak ingin diubah)
                                    </small>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="konfirmasi password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- ROLE USER -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role User</label>
                                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option disabled>Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- STATUS AKUN -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Akun</label>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option disabled>Pilih Status</option>
                                        <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>
                                            ✅ Aktif
                                        </option>
                                        <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>
                                            ❌ Nonaktif
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <a href="{{ route('users.index') }}" class="btn btn-default mr-1">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>

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

</x-layouts.app>

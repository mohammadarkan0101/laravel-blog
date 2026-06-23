<x-layouts.app title="Tambah Blog">

    <!-- CONTENT HEADER -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Blog</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Tambah Blog
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

                            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-2">
                                    <span class="font-weight-bold" style="font-size: 1rem;">
                                        Thumbnail
                                    </span>
                                </div>

                                <img id="thumbnail" 
                                     src="{{ asset('assets/img/default-thumbnail.webp') }}" 
                                     data-default="{{ asset('assets/img/default-thumbnail.webp') }}" 
                                     class="img-fluid img-thumbnail img-post mb-3" 
                                     alt="Thumbnail"
                                >

                                <!-- JUDUL BLOG -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Blog</label>
                                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- KONTEN BLOG -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Konten Blog</label>
                                    <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- THUMBNAIL -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Thumbnail</label>
                                    <div class="custom-file">
                                        <input type="file" id="image" name="image" class="custom-file-input @error('image') is-invalid @enderror" accept=".png,.jpg,.jpeg">
                                        <label class="custom-file-label" for="image">Pilih file...</label>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- STATUS BLOG -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Blog</label>
                                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                            📝 Draft
                                        </option>
                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                            🚀 Published
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <a href="{{ route('blogs.index') }}" class="btn btn-default mr-1">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>

                                <button type="submit" class="btn btn-default">
                                    <i class="bi bi-save"></i> Simpan
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
            $(document).ready(function() {
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 100
                });

                $('.custom-file-input').on('change', function() {
                    const fileName = this.files[0]?.name ?? 'Pilih file...';
                    $(this).next('.custom-file-label').text(fileName);
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                const inputImage   = document.getElementById('image');
                const previewImage = document.getElementById('thumbnail');

                if (!inputImage || !previewImage) return;

                let previewUrl = null;

                inputImage.addEventListener('change', (e) => {
                    const file = e.target.files?.[0];

                    if (previewUrl) {
                        URL.revokeObjectURL(previewUrl);
                    }

                    if (!file) return;

                    previewUrl = URL.createObjectURL(file);
                    previewImage.src = previewUrl;
                });
            });
        </script>
    @endpush

</x-layouts.app>
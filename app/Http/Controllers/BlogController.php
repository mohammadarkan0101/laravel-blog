<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Format;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\StoreDataBlogRequest;
use App\Http\Requests\UpdateDataBlogRequest;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:editor']);
    }

    public function datatable(): JsonResponse
    {
        $blogs = Blog::query()
            ->with('user:id,name')
            ->select(['id', 'user_id', 'title', 'status', 'created_at'])
            ->latest();

        return DataTables::eloquent($blogs)
            ->addIndexColumn()
            ->addColumn('author', fn (Blog $blog) => $blog->user->name)
            ->editColumn('created_at', fn (Blog $blog) => $blog->created_at?->format('M d, Y H:i'))
            ->editColumn('status', fn (Blog $blog) => $blog->isPublished()
                ? '<span class="badge badge-success">Published</span>'
                : '<span class="badge badge-danger">Draft</span>'
            )
            ->addColumn('action', fn (Blog $blog) => view('pages.admin.blogs.action', compact('blog'))->render())
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function index(): View
    {
        return view('pages.admin.blogs.index');
    }

    public function create(): View
    {
        return view('pages.admin.blogs.create');
    }

    public function store(StoreDataBlogRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleUploadImage($request);
        }

        Blog::create($validated);

        return to_route('blogs.index')->with('success', 'Blog berhasil disimpan.');
    }

    public function edit(Blog $blog): View
    {
        Gate::authorize('update', $blog);

        return view('pages.admin.blogs.edit', compact('blog'));
    }

    public function update(UpdateDataBlogRequest $request, Blog $blog): RedirectResponse
    {
        Gate::authorize('update', $blog);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->handleDeleteImage($blog);
            $validated['image'] = $this->handleUploadImage($request);
        }

        $blog->update($validated);

        return to_route('blogs.index')->with('success', 'Blog berhasil diupdate.');
    }

    public function destroy(Blog $blog): RedirectResponse
    {
        Gate::authorize('delete', $blog);

        $this->handleDeleteImage($blog);

        $blog->delete();

        return to_route('blogs.index')->with('success', 'Blog berhasil didelete.');
    }

    private function handleUploadImage(Request $request): string
    {
        // Mengambil input file gambar dari request
        $uploadedFile = $request->file('image');
        // Membuat nama file baru secara acak dengan ekstensi .webp
        $newImageName = Str::random(10) . '.webp';
        // Menentukan lokasi folder tempat menyimpan gambar
        $locationPath = storage_path('app/public/blogs');
        // Membuat instance ImageManager dari library Intervention Image
        $imageManager = ImageManager::usingDriver(Driver::class);
        // Membaca file gambar yang diupload
        $processImage = $imageManager->decodePath($uploadedFile);
        // Mengubah format gambar menjadi WEBP dengan kualitas 85
        $processImage->encodeUsingFormat(Format::WEBP, quality: 85);
        // Simpan gambar yang telah diproses ke path tujuan dengan nama file baru
        $processImage->save($locationPath . '/' . $newImageName);
        // Mengembalikan nama file gambar yang baru dibuat
        return $newImageName;
    }

    private function handleDeleteImage(Blog $blog): void
    {
        // Mendapatkan path dari lokasi folder tempat menyimpan gambar
        $imagePath = storage_path('app/public/blogs/' . $blog->image);
        // Memeriksa apakah file gambar yang ada diserver dan database
        if ($blog->image && file_exists($imagePath)) {
            // Menghapus file gambar yang ada diserver dan database
            unlink($imagePath);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Format;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserPasswordRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrator|editor']);
    }

    public function index(): View
    {
        $user = Auth::user();

        return view('pages.admin.profile.index', compact('user'));
    }

    public function updateUserProfile(UpdateUserProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->handleDeleteImage($user);
            $data['image'] = $this->handleUploadImage($request);
        } elseif ($request->boolean('removeImage')) {
            $this->handleDeleteImage($user);
            $data['image'] = null;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->save();

        return back()->with('success', 'Profile berhasil diupdate.');
    }

    public function updateUserPassword(UpdateUserPasswordRequest $request): RedirectResponse
    {
        $password = $request->validated('password');

        Auth::user()->update([
            'password' => Hash::make($password)
        ]);

        return back()->with('success', 'Password berhasil diupdate.');
    }

    private function handleUploadImage(Request $request): string
    {
        // Mengambil input file gambar dari request
        $uploadedFile = $request->file('image');
        // Membuat nama file baru secara acak dengan ekstensi .webp
        $newImageName = Str::random(10) . '.webp';
        // Menentukan lokasi folder tempat menyimpan gambar
        $locationPath = storage_path('app/public/users');
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

    private function handleDeleteImage(User $user): void
    {
        // Mendapatkan path dari lokasi folder tempat menyimpan gambar
        $imagePath = storage_path('app/public/users/' . $user->image);
        // Memeriksa apakah file gambar yang ada diserver dan database
        if ($user->image && file_exists($imagePath)) {
            // Menghapus file gambar yang ada diserver dan database
            unlink($imagePath);
        }
    }
}

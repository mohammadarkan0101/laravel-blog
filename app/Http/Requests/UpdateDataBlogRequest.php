<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => 'required|min:3|max:255',
            'content' => 'required|min:3',
            'image'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status'  => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul wajib diisi.',
            'title.min'        => 'Judul harus terdiri dari minimal 3 karakter.',
            'title.max'        => 'Judul tidak boleh lebih dari 255 karakter.',

            'content.required' => 'Konten wajib diisi.',
            'content.min'      => 'Konten harus terdiri dari minimal 3 karakter.',

            'image.image'      => 'Format gambar tidak didukung.',
            'image.mimes'      => 'Format gambar yang diperbolehkan: png,jpg,jpeg.',
            'image.max'        => 'Ukuran gambar maksimal adalah 2MB.',

            'status.required'  => 'Status wajib dipilih.',
            'status.in'        => 'Status harus berupa draft atau published.',
        ];
    }
}

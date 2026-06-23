<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|min:3|max:255',
            'email' => "required|min:6|max:255|email|unique:users,email," . Auth::id(),
            'phone' => "nullable|digits_between:9,15|unique:users,phone," . Auth::id(),
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Nama wajib diisi.',
            'name.min'             => 'Nama harus terdiri dari minimal 3 karakter.',
            'name.max'             => 'Nama tidak boleh lebih dari 255 karakter.',

            'email.required'       => 'Email wajib diisi.',
            'email.min'            => 'Email harus terdiri dari minimal 6 karakter.',
            'email.max'            => 'Email tidak boleh lebih dari 255 karakter.',
            'email.email'          => 'Email harus bernilai valid.',
            'email.unique'         => 'Email ini sudah terdaftar.',

            'phone.digits_between' => 'Nomor telepon harus terdiri dari 9 sampai 15 digit.',
            'phone.unique'         => 'Nomor telepon ini sudah terdaftar.',

            'image.image'          => 'Format gambar tidak didukung.',
            'image.mimes'          => 'Format gambar yang diperbolehkan: png,jpg,jpeg.',
            'image.max'            => 'Ukuran gambar maksimal adalah 2MB.',
        ];
    }
}
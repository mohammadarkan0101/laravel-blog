<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|min:3|max:255',
            'email'    => 'required|min:6|max:255|email|unique:users,email',
            'phone'    => 'required|digits_between:9,15|unique:users,phone',
            'password' => 'required|min:8|confirmed',
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

            'phone.required'       => 'Nomor telepon wajib diisi.',
            'phone.digits_between' => 'Nomor telepon harus terdiri dari 9 sampai 15 digit.',
            'phone.unique'         => 'Nomor telepon ini sudah terdaftar.',

            'password.required'    => 'Password wajib diisi.',
            'password.min'         => 'Password harus terdiri dari minimal 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required|current_password',
            'password'     => 'required|min:8|confirmed|different:old_password',
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required'         => 'Password lama wajib diisi.',
            'old_password.current_password' => 'Password lama tidak cocok.',

            'password.required'             => 'Password baru wajib diisi.',
            'password.min'                  => 'Password baru harus terdiri dari minimal 8 karakter.',
            'password.confirmed'            => 'Konfirmasi password tidak cocok.',
            'password.different'            => 'Password baru harus berbeda dengan password lama.',
        ];
    }
}

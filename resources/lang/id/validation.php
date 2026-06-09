<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan memiliki banyak versi seperti aturan 'size'.
    | Jangan ragu untuk menyesuaikan setiap pesan yang ada di sini.
    |
    */

    'accepted'        => ':attribute harus diterima.',
    'active_url'      => ':attribute bukan URL yang valid.',
    'after'           => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal'  => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'           => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'      => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'       => ':attribute hanya boleh berisi huruf dan angka.',
    'array'           => ':attribute harus berupa array.',
    'before'          => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',

    'between' => [
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'file'    => ':attribute harus berukuran antara :min sampai :max kilobyte.',
        'string'  => ':attribute harus terdiri dari :min sampai :max karakter.',
        'array'   => ':attribute harus memiliki :min sampai :max anggota.',
    ],

    'boolean'        => ':attribute harus bernilai benar (true) atau salah (false).',
    'confirmed'      => 'Konfirmasi :attribute tidak cocok.',
    'date'           => ':attribute bukan tanggal yang valid.',
    'date_equals'    => ':attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'    => ':attribute tidak cocok dengan format :format.',
    'different'      => ':attribute dan :other harus berbeda.',
    'digits'         => ':attribute harus terdiri dari :digits angka.',
    'digits_between' => ':attribute harus terdiri dari :min sampai :max angka.',
    'dimensions'     => ':attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'       => ':attribute memiliki nilai yang sama (duplikat).',
    'email'          => ':attribute harus berupa alamat email yang valid.',
    'ends_with'      => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'exists'         => ':attribute yang dipilih tidak valid.',
    'file'           => ':attribute harus berupa berkas.',
    'filled'         => ':attribute harus memiliki nilai.',

    'gt' => [
        'numeric' => ':attribute harus bernilai lebih besar dari :value.',
        'file'    => ':attribute harus berukuran lebih besar dari :value kilobyte.',
        'string'  => ':attribute harus memiliki lebih dari :value karakter.',
        'array'   => ':attribute harus memiliki lebih dari :value anggota.',
    ],

    'gte' => [
        'numeric' => ':attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'file'    => ':attribute harus berukuran lebih besar dari atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus memiliki :value karakter atau lebih.',
        'array'   => ':attribute harus memiliki :value anggota atau lebih.',
    ],

    'image'    => ':attribute harus berupa gambar.',
    'in'       => ':attribute yang dipilih tidak valid.',
    'in_array' => ':attribute tidak ditemukan di dalam :other.',
    'integer'  => ':attribute harus berupa bilangan bulat.',
    'ip'       => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'     => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'     => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'     => ':attribute harus berupa string JSON yang valid.',

    'lt' => [
        'numeric' => ':attribute harus bernilai kurang dari :value.',
        'file'    => ':attribute harus berukuran kurang dari :value kilobyte.',
        'string'  => ':attribute harus memiliki kurang dari :value karakter.',
        'array'   => ':attribute harus memiliki kurang dari :value anggota.',
    ],

    'lte' => [
        'numeric' => ':attribute harus bernilai kurang dari atau sama dengan :value.',
        'file'    => ':attribute harus berukuran kurang dari atau sama dengan :value kilobyte.',
        'string'  => ':attribute harus memiliki :value karakter atau kurang.',
        'array'   => ':attribute tidak boleh memiliki lebih dari :value anggota.',
    ],

    'max' => [
        'numeric' => ':attribute maksimal bernilai :max.',
        'file'    => ':attribute maksimal berukuran :max kilobyte.',
        'string'  => ':attribute maksimal terdiri dari :max karakter.',
        'array'   => ':attribute maksimal memiliki :max anggota.',
    ],

    'mimes'     => ':attribute harus berupa berkas dengan jenis: :values.',
    'mimetypes' => ':attribute harus berupa berkas dengan tipe: :values.',

    'min' => [
        'numeric' => ':attribute minimal bernilai :min.',
        'file'    => ':attribute minimal berukuran :min kilobyte.',
        'string'  => ':attribute minimal terdiri dari :min karakter.',
        'array'   => ':attribute minimal memiliki :min anggota.',
    ],

    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'password'             => 'Kata sandi tidak benar.',
    'present'              => ':attribute harus ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => ':attribute wajib diisi kecuali :other bernilai :values.',
    'required_with'        => ':attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => ':attribute wajib diisi bila semua :values tersedia.',
    'required_without'     => ':attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => ':attribute wajib diisi bila tidak ada satu pun dari :values yang tersedia.',
    'same'                 => ':attribute dan :other harus sama.',

    'size' => [
        'numeric' => ':attribute harus bernilai :size.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'string'  => ':attribute harus terdiri dari :size karakter.',
        'array'   => ':attribute harus memiliki :size anggota.',
    ],

    'starts_with' => ':attribute harus diawali dengan salah satu dari berikut: :values.',
    'string'      => ':attribute harus berupa string.',
    'timezone'    => ':attribute harus berupa zona waktu yang valid.',
    'unique'      => ':attribute sudah digunakan.',
    'uploaded'    => ':attribute gagal diunggah.',
    'url'         => 'Format :attribute tidak valid.',
    'uuid'        => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi khusus untuk atribut tertentu
    | dengan menggunakan konvensi "attribute.rule".
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'pesan-kustom',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Kustom Nama Atribut
    |--------------------------------------------------------------------------
    |
    | Gantilah placeholder atribut menjadi nama yang lebih deskriptif
    | agar pesan validasi lebih mudah dipahami oleh pengguna.
    |
    */

    'attributes' => [],
];

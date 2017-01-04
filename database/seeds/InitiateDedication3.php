<?php

use Illuminate\Database\Seeder;
use App\StatusCode;

class InitiateDedication3 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusCode::create([
            'code'        => 'VA',
            'description' => 'Menunggu Verifikasi Anggota',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'UU',
            'description' => 'Menunggu Unggah Usulan',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'PR',
            'description' => 'Penentuan Reviewer',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'MR',
            'description' => 'Menunggu Untuk Direview',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'RS',
            'description' => 'Review Selesai, menunggu hasil',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'PU',
            'description' => 'Perbaikan, Menunggu Unggah Usulan Perbaikan',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'UD',
            'description' => 'Usulan Diterima',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'UT',
            'description' => 'Usulan Ditolak',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'LK',
            'description' => 'Menunggu Laporan Kemajuan',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'LA',
            'description' => 'Menunggu Laporan Akhir',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'UL',
            'description' => 'Menunggu Luaran',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'VL',
            'description' => 'Menunggu Validasi Luaran',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'PS',
            'description' => 'Pengabdian Selesai',
            'created_by'  => 'admin',
        ]);
    }
}

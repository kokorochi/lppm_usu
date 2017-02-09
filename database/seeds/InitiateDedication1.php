<?php

use Illuminate\Database\Seeder;

class InitiateDedication1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//      Initiate Category_types
        $category_types = new App\Category_type();

        $category_types->create(
            ['category_name' => 'Hibah', 'created_by' => 'admin']
        );
        $category_types->create(
            ['category_name' => 'Kerja Sama', 'created_by' => 'admin']
        );
        $category_types->create(
            ['category_name' => 'Mandiri', 'created_by' => 'admin']
        );


//      End Category_types

//      Initiate Research Type
        $research_type = new App\ResearchType();

        $research_type->create(
            ['research_name' => 'Mono Tahun', 'created_by' => 'admin']
        );
        $research_type->create(
            ['research_name' => 'Multi Tahun', 'created_by' => 'admin']
        );
        $research_type->create(
            ['research_name' => 'Berbasis Pengabdian', 'created_by' => 'admin']
        );
//      End Initiate Dedication_types

//      Output Type
        Output_type::create([
            'output_code' => 'JS',
            'output_name' => 'Jasa',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'MT',
            'output_name' => 'Metode',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PB',
            'output_name' => 'Produk/Barang',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PT',
            'output_name' => 'Paten',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'BP',
            'output_name' => 'Buku Panduan',
            'created_by'  => 'admin',
        ]);
//      End Output Type

//      Status Code
        StatusCode::create([
            'code'        => 'SS',
            'description' => 'Simpan Sementara',
            'created_by'  => 'admin',
        ]);
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
            'code'        => 'RL',
            'description' => 'Revisi Luaran',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'PS',
            'description' => 'Pengabdian Selesai',
            'created_by'  => 'admin',
        ]);
        StatusCode::create([
            'code'        => 'LT',
            'description' => 'Validasi Luaran Diterima',
            'created_by'  => 'admin',
        ]);
//      End Status Code

//      Conclusion
        Conclusion::create([
            'conclusion_desc' => 'Dapat dilanjutkan tanpa perbaikan',
            'created_by'      => 'admin',
        ]);
        Conclusion::create([
            'conclusion_desc' => 'Perlu perbaikan',
            'created_by'      => 'admin',
        ]);
        Conclusion::create([
            'conclusion_desc' => 'Tidak layak dilanjutkan',
            'created_by'      => 'admin',
        ]);
//      End Conclusion
    }
}

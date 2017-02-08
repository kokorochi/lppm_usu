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
            'output_code' => 'JI',
            'output_name' => 'Jurnal Internasional',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'JNT',
            'output_name' => 'Jurnal Nasional Terakreditasi',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'JTT',
            'output_name' => 'Jurnal Nasional Terakreditasi Tidak Terakreditas',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'AT',
            'output_name' => 'Ajar / Teks',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PFI',
            'output_name' => 'Pemakalah Forum Ilmiah (Internasional)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PFN',
            'output_name' => 'Pemakalah Forum Ilmiah (Nasional)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PFR',
            'output_name' => 'Pemakalah Forum Ilmiah (Regional)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'HKI',
            'output_name' => 'Hak Kekayaan Intelektual (HKI)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'NPK',
            'output_name' => 'Non Pengabdian / Kontrak Kerja',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PSN',
            'output_name' => 'Pengabdian Sumber Dana Non Ditlitabmas',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PSD',
            'output_name' => 'Pengabdian Sumber Dana Ditlitabmas (Desentralisasi)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PSK',
            'output_name' => 'Pengabdian Sumber Dana Ditlitabmas (Kompetitif)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PA',
            'output_name' => 'Peneliti Asing',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'PKF',
            'output_name' => 'Penyelenggaraan Kegiatan Forum Ilmiah (Seminar / Lokakarya)',
            'created_by'  => 'admin',
        ]);
        Output_type::create([
            'output_code' => 'LL',
            'output_name' => 'Luaran Lain',
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

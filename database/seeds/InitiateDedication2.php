<?php

use Illuminate\Database\Seeder;
use App\Output_type;

class InitiateDedication2 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}

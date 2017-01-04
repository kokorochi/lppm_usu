<?php

use Illuminate\Database\Seeder;
use App\Conclusion;

class InitiateDedication4 extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conclusion::create([
            'conclusion_desc' => 'Dapat dilanjutkan tanpa perbaikan',
            'created_by' => 'admin',
        ]);
        Conclusion::create([
            'conclusion_desc' => 'Perlu perbaikan',
            'created_by' => 'admin',
        ]);
        Conclusion::create([
            'conclusion_desc' => 'Tidak layak dilanjutkan',
            'created_by' => 'admin',
        ]);
    }
}

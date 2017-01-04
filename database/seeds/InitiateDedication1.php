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

//      Initiate Dedication_types
        $dedication_types = new App\Dedication_type();

        $dedication_types->create(
            ['dedication_name' => 'Mono Tahun', 'created_by' => 'admin']
        );
        $dedication_types->create(
            ['dedication_name' => 'Multi Tahun', 'created_by' => 'admin']
        );
        $dedication_types->create(
            ['dedication_name' => 'Berbasis Penelitian', 'created_by' => 'admin']
        );
//      End Initiate Dedication_types
    }
}

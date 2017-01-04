<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class Auth_Object_Ref_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new App\Auth_Object_Ref;
        $store->create(['object_desc' => 'Super User', 'created_by' => 'admin']);
        $store->create(['object_desc' => 'Operator', 'created_by' => 'admin']);
        $store->create(['object_desc' => 'Reviewer', 'created_by' => 'admin']);
        $store->create(['object_desc' => 'Dosen', 'created_by' => 'admin']);
    }
}

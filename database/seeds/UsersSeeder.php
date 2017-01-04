<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new App\User;
        $store->create([
            'nidn'      => 'superuser',
            'password'  => bcrypt('superst4r')
        ]);
        $store->create([
            'nidn'      => '198206152009101001',
            'password'  => bcrypt('operator12')
        ]);
    }
}

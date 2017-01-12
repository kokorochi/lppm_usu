<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Auth_Object_Ref_Seeder::class);
        $this->call(UsersSeeder::class);
        $this->call(AuthsSeeder::class);
        $this->call(InitiateDedication1::class);
        $this->call(InitiateDedication2::class);
        $this->call(InitiateDedication3::class);
        $this->call(InitiateDedication4::class);
        $this->call(InitiateLecturer::class);
    }
}

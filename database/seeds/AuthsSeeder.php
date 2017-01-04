<?php

use Illuminate\Database\Seeder;

class AuthsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new App\Auths;
        $users = new App\User;
        $users = $users->all();
        foreach ($users as $user)
        {
            if ($user->nidn === 'superuser') //Super User
            {
                $store->create([
                    'user_id'            => $user->id,
                    'auth_object_ref_id' => '1',
                    'begin_date'         => '2000-01-01',
                    'end_date'           => '9999-12-31',
                    'created_by'         => 'admin',
                ]);
            } elseif ($user->nidn === '198206152009101001') //Operator
            {
                $store->create([
                    'user_id'            => $user->id,
                    'auth_object_ref_id' => '2',
                    'begin_date'         => '2000-01-01',
                    'end_date'           => '9999-12-31',
                    'created_by'         => 'admin',
                ]);
            } 
        }
    }
}

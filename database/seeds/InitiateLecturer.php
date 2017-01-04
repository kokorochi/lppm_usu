<?php

use Illuminate\Database\Seeder;

class InitiateLecturer extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lecturers = \App\ModelSDM\Lecturer::all();
        foreach ($lecturers as $lecturer)
        {
            $store = new \App\User();
            $store->create([
                'nidn'     => $lecturer->employee_card_serial_number,
                'password' => $lecturer->password,
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Http\Models\User::create([
            'identity_number' => '0522019201',
            'name'	=> 'Dewi Anisa Istiqomah',
            'email'	=> 'dewianisaist@amikom.ac.id',
            'password'	=> bcrypt('12345678')
        ]);

        \App\Http\Models\User::create([
            'identity_number' => '0523049301',
            'name'	=> 'Vikky Aprelia Windarni',
            'email'	=> 'vikkyaprelia@gmail.com',
            'password'	=> bcrypt('12345678')
        ]);
    }
}

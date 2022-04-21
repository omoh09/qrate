<?php

use App\Admin;
use Illuminate\Database\Seeder;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'info@qrateart.com',
            'password' => Hash::make('password')
        ],
        [
            'name' => 'admin',
            'email' => 'admin@qrateart.com',
            'password' => Hash::make('password')
        ]
        );
    }
}

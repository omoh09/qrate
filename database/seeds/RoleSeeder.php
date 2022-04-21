<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::create(
            [
                'name' => 'qrater'
            ]
        );
        \App\Role::create(
            [
                'name' => 'artist'
            ]
        );
        \App\Role::create(
            [
                'name' => 'gallery'
            ]
        );
        \App\Role::create(
            [
                'name' => 'supplier'
            ]
        );
        \App\Role::create(
            [
                'name' => 'admin'
            ]
        );
    }
}

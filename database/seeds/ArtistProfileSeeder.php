<?php

use App\Profile;
use App\User;
use Illuminate\Database\Seeder;

class ArtistProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Profile::class,10)->create();
        $users = User::all();

        foreach ($users as $user)
        {
            $user->profilePicture()->create(
                [
                    'url' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1604251409/Artworks/oiekszowajmositjwbwq.png',
                    'thumbnail' => 'https://res.cloudinary.com/onifs-cloud/image/upload/v1604251409/thumbnail/jgz84ddnpoi9ufuo2emd.png'
                ]
            );
            $user->profile()->create(
                [
                    'bio' => 'This is the user Biography you can check back later',
                    'username' => $user->name,
                    'address'  => 'users address as we know it ',
                ]
            );
        }
    }
}

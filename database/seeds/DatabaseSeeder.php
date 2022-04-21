<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call( ArtSupplyCategory::class);
        $this->call(UserSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(ArtistProfileSeeder::class);
        $this->call(ArtworksSeeder::class);
         $this->call(CommentsSeeder::class);
         $this->call(LikesSeeder::class);
         $this->call(ArtGallerySeeder::class);
         $this->call(CatalogueSeeder::class);
         $this->call(ArtsuppliesSeeder::class);
         $this->call(ExhibitionSeeder::class);
         $this->call(CartSeeder::class);
         $this->call(ArtGalleryEASeeder::class);
        $this->call(NotificationSeeder::class);

//        $this->call(PlansSeeder::class);
//        $this->call(adminSeeder::class);
        // $this->call(AuctionSeeder::class);
    }
}

<?php

use App\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::create(
            [
                'id'  => 1,
                'name'  => 'Acrylic Painting',
                'color' => '#BC0272',
                'code' => 'acrylic'
            ]
        );
        Categories::create(
            [
                'id'  => 2,
                'name'  => 'Animation',
                'color' => '#6372C1',
                'code' => 'animation'
            ]
        );
        Categories::create(
            [
                'id'  => 3,
                'name'  => 'Calligraphy',
                'color' => '#F7931E',
                'code' => 'calligraphy'
            ]
        );
        Categories::create(
            [
                'id'  => 4,
                'name'  => 'Ceramics',
                'color' => '#277839',
                'code' => 'ceramics'
            ]
        );
        Categories::create(
            [
                'id'  => 5,
                'name'  => 'Charcoal Drawing',
                'color' => '#955BAS',
                'code' => 'charcoal'
            ]
        );
        Categories::create(
            [
                'id'  => 6,
                'name'  => 'Clay Scuplture',
                'color' => '#F44336',
                'code' => 'clay'
            ]
        );
        Categories::create(
            [
                'id'  => 7,
                'name'  => 'Comics',
                'color' => '#FF005C',
                'code' => 'comic'
            ]
        );
        Categories::create(
            [
                'id'  => 8,
                'name'  => 'Conte Drawing',
                'color' => '#229B1F',
                'code' => 'conte'
            ]
        );
        Categories::create(
            [
                'id'  => 9,
                'name'  => 'Digital Art',
                'color' => '#8000FF',
                'code' => 'digital-art'
            ]
        );
        Categories::create(
            [
                'id'  => 10,
                'name'  => 'Digital Collage',
                'color' => '#DB8C16',
                'code' => 'digital-collage'
            ]
        );
        Categories::create(
            [
                'id'  => 11,
                'name'  => 'Digital Painting',
                'color' => '#E06426',
                'code' => 'digital-paint'
            ]
        );
        Categories::create(
            [
                'id'  => 12,
                'name'  => 'Graffiti Art',
                'color' => '#8BC605',
                'code' => 'graffiti'
            ]
        );
        Categories::create(
            [
                'id'  => 13,
                'name'  => 'Handmade',
                'color' => '#05D8E5',
                'code' => 'handmade'
            ]
        );
        Categories::create(
            [
                'id'  => 14,
                'name'  => 'Illustrations',
                'color' => '#805333',
                'code' => 'illustration'
            ]
        );
        Categories::create(
            [
                'id'  => 15,
                'name'  => 'Lino Cut',
                'color' => '#607D8B',
                'code' => 'lino'
            ]
        );
        Categories::create(
            [
                'id'  => 16,
                'name'  => 'Mixed Media',
                'color' => '#FF18BE',
                'code' => 'mixed'
            ]
        );
        Categories::create(
            [
                'id'  => 17,
                'name'  => 'Oil Painting',
                'color' => '#6372C1',
                'code' => 'oil'
            ]
        );
        Categories::create(
            [
                'id'  => 18,
                'name'  => 'Pastel Drawing',
                'color' => '#3E3E3E',
                'code' => 'pastel'
            ]
        );
        Categories::create(
            [
                'id'  => 19,
                'name'  => 'Performance Art',
                'color' => '#4FACFE',
                'code' => 'performance'
            ]
        );
        Categories::create(
            [
                'id'  => 20,
                'name'  => 'Photography',
                'color' => '#3645C7',
                'code' => 'photography'
            ]
        );
        Categories::create(
            [
                'id'  => 21,
                'name'  => 'Portraiture',
                'color' => '#111111',
                'code' => 'portraiture'
            ]
        );
        Categories::create(
            [
                'id'  => 22,
                'name'  => 'Print Making',
                'color' => '#7B7B7B',
                'code' => 'print'
            ]
        );
        Categories::create(
            [
                'id'  => 23,
                'name'  => 'Recycle Art',
                'color' => '#87CED9',
                'code' => 'recycle'
            ]
        );
        Categories::create(
            [
                'id'  => 24,
                'name'  => 'Sculpture',
                'color' => '#2E384D',
                'code' => 'sculpture'
            ]
        );
        Categories::create(
            [
                'id'  => 25,
                'name'  => 'Textile',
                'color' => '#FFBC00',
                'code' => 'textile'
            ]
        );
        Categories::create(
            [
                'id'  => 26,
                'name'  => 'Videography',
                'color' => '#A33A3A',
                'code' => 'videography'
            ]
        );
        Categories::create(
            [
                'id'  => 27,
                'name'  => 'Watercolor painting',
                'color' => '#A3983A',
                'code' => 'watercolor'
            ]
        );
    }
}

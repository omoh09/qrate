<?php

use App\SuppliesCategory;
use Illuminate\Database\Seeder;

class ArtSupplyCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SuppliesCategory::create(
            [
                'name' => 'Art Desks & Easels'
            ]
        );
        SuppliesCategory::create(
                    [
                        'name' => 'Art Gift Sets'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Artist Canvas'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Hand & Lettering'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Ink & Calligraphy'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Markers, Pens & Pencils'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Paint Pouring'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Painting Supplies'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Paper and Drawing Pads'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Printmaking'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Resin'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Sculpture'
                    ]
                );
        SuppliesCategory::create(
                    [
                        'name' => 'Sketchbooks & journals'
                    ]
                );
    }
}

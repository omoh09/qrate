<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CollectionsArtworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections_artworks' , function (Blueprint $table){
           $table->unsignedBigInteger('collection_id');
           $table->unsignedBigInteger('artwork_id');
            $table->foreign('collection_id')
                ->references('id')
                ->on('collections')
                ->cascadeOnDelete();
            $table->foreign('artwork_id')
                ->references('id')
                ->on('artworks')
                ->cascadeOnDelete();
            $table->primary(['collection_id','artwork_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections_artworks');
    }
}

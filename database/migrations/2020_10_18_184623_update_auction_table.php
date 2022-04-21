<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auction', function (Blueprint $table){
            $table->dropColumn('name');
            $table->dropColumn('description');
            $table->dropColumn('frame');
            $table->dropColumn('minimum_bid');
            $table->dropColumn('author');
            $table->boolean('approved')->default(false);
            $table->unsignedBigInteger('artwork_id');
            $table->foreign('artwork_id')
                ->references('id')
                ->on('artworks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auction', function (Blueprint $table) {
        });
    }
}

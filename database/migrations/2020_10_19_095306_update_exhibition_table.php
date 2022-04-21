<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExhibitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
//            $table->dropColumn('url');
            $table->unsignedBigInteger('user_id');
            $table->text('address')->nullable();
            $table->date('event_date')->nullable();
            $table->time('time',0)->nullable();
            $table->string('country')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('event_date');
            $table->dropColumn('time');
            $table->dropColumn('country');
        });
    }
}

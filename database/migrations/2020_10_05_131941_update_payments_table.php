<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->dropColumn('name');
            $table->dropColumn('price');
            $table->uuid('checkout_id');

            $table->foreign('checkout_id')
                ->references('id')
                ->on('checkouts')
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
        Schema::table('Payment', function (Blueprint $table) {
            //
        });
    }
}

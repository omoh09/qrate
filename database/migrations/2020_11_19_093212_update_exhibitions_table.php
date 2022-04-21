<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExhibitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->unsignedBigInteger('sold_ticket_no')->nullable()->default(0)->after('event_date');
            $table->unsignedBigInteger('available_ticket_no')->nullable()->default(0)->after('event_date');
            $table->unsignedBigInteger('initial_ticket_no')->nullable()->default(0)->after('event_date');
            $table->string('ticket_price')->nullable()->default(0)->after('event_date');
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
            $table->dropColumn('sold_ticket_no');
            $table->dropColumn('available_ticket_no');
            $table->dropColumn('initial_ticket_no');
            $table->dropColumn('ticket_price');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableStatusPayoutWithUpdateSomeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->unique();
        });

        Schema::create('payouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academic_year_id')->unsigned();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->decimal('amount', 13,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->dropForeign(['academic_year_id']);
            $table->removeColumn(['academic_year_id']);
            $table->dropForeign(['status_id']);
            $table->removeColumn(['status_id']);
        });

        Schema::dropIfExists('payouts');
        Schema::dropIfExists('statuses');
    }
}

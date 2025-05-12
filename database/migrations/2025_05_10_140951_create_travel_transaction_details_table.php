<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('travel_transaction_details', function (Blueprint $table) {
            $table->char('Oid', 38)->primary();
            $table->unsignedBigInteger('CreateBy');
            $table->foreign('CreateBy')->references('user_id')->on('users')->onDelete('cascade');

            $table->timestamp('CreatedAt')->useCurrent();

            $table->char('TravelTransaction', 38);
            $table->foreign('TravelTransaction')->references('Oid')->on('travel_transactions')->onDelete('cascade');

            $table->string('Code', 35)->nullable();
            $table->longText('Description')->nullable();
            $table->integer('TotalPax')->default(0);

            $table->string('Name', 35)->nullable();
            $table->string('Email', 35)->nullable();
            $table->string('PhoneNumber', 35)->nullable();

            $table->date('EnterDate')->nullable();
            $table->date('ExitDate')->nullable();

            $table->boolean('isCustomItineraries')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_transaction_details');
    }
}
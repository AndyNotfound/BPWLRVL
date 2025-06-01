<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('travel_transactions', function (Blueprint $table) {
            $table->char('Oid', 38)->primary();
            $table->unsignedBigInteger('CreateBy')->nullable();
            $table->char('Packages', 38)->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
            $table->string('Code', 35)->nullable();
            $table->double('Price')->default(0);
            $table->longText('Description')->nullable();

            $table->foreign('CreateBy', 'fk_travel_transactions_createby')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('Packages', 'fk_travel_transactions_packages')
                ->references('Oid')
                ->on('packages')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_transactions');
    }
};

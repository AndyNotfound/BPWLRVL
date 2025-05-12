<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('travel_transaction_details', function (Blueprint $table) {
            $table->char('Itineraries', 38)->nullable();
            $table->foreign('Itineraries')->references('Oid')->on('itineraries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_transaction_details', function (Blueprint $table) {
            $table->dropColumn('Itineraries');
        });
    }
};

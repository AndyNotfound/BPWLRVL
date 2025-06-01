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
            $table->longText('Itineraries', 38)->nullable();
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

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
            $table->string('Type', 35)->nullable();
            $table->string('PaymentID', 55)->nullable();
            $table->string('Status', 35)->nullable();
            $table->timestamp('ExpiresAt')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('travel_transaction_details', function (Blueprint $table) {
            $table->dropColumn('Type');
            $table->dropColumn('PaymentID');
            $table->dropColumn('Status');
            $table->dropColumn('ExpiresAt');
        });
    }
};

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
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('isCustomItineraries')->default(false);
            $table->boolean('isFavorites')->default(false);
            $table->boolean('isSeasonal')->default(false);
            $table->boolean('isCustom')->default(false);
            $table->boolean('isMustsee')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('isCustomItineraries');
            $table->dropColumn('isFavorites');
            $table->dropColumn('isSeasonal');
            $table->dropColumn('isCustom');
            $table->dropColumn('isMustSee');
        });
    }
};

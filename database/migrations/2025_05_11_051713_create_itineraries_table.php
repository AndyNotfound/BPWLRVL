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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->char('Oid', 38)->primary();
            $table->unsignedBigInteger('CreateBy');
            $table->foreign('CreateBy')->references('user_id')->on('users')->onDelete('cascade');

            $table->timestamp('CreatedAt')->useCurrent();

            $table->unsignedBigInteger('Role');
            $table->foreign('Role')->references('id')->on('roles')->onDelete('cascade');

            $table->string('Code', 35)->nullable();
            $table->string('Name', 35)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};

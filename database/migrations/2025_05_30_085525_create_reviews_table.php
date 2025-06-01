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
        Schema::create('reviews', function (Blueprint $table) {
            $table->char('Oid', 38)->primary();
            $table->unsignedBigInteger('CreateBy')->nullable();
            $table->foreign('CreateBy', 'fk_reviews_createby')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamp('CreatedAt')->useCurrent();
            $table->char('Packages', 38);
            $table->foreign('Packages', 'fk_reviews_packages')
                ->references('Oid')
                ->on('packages')
                ->onDelete('cascade');
            $table->longText('Review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

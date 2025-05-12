<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->char('Oid', 38)->primary();
            
            $table->unsignedBigInteger('CreateBy');
            $table->foreign('CreateBy')->references('user_id')->on('users')->onDelete('cascade');

            $table->timestamp('CreatedAt')->useCurrent();

            $table->string('Name', 35)->nullable();
            $table->string('Title', 50)->nullable();
            $table->longText('Description')->nullable();
            $table->string('Location', 35)->nullable();
            $table->string('HeadImage', 100)->nullable();
            $table->string('SubImage1', 100)->nullable();
            $table->string('SubImage2', 100)->nullable();

            $table->dateTime('ValidDateStart')->nullable();
            $table->dateTime('ValidDateEnd')->nullable();

            $table->double('Price')->default(0);
            $table->integer('MaxCapacity')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};


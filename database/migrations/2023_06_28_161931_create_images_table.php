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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('image_type', 25)->default('');
            $table->binary('image', 'LONGBLOB');
            $table->string('image_size', 25)->default('');
            $table->string('image_ctgy', 25)->default('');
            $table->string('image_name', 1000)->default('');
            $table->unsignedBigInteger('item_id');

            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};

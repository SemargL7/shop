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
        Schema::create('items_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('description_description_id')->unsigned();
            $table->bigInteger('howtouse_description_id')->unsigned();

            $table->foreign('description_description_id')->references('id')->on('descriptions')->cascadeOnDelete();
            $table->foreign('howtouse_description_id')->references('id')->on('descriptions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_infos');
    }
};

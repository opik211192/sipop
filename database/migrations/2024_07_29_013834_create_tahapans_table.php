<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tahapans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jaringan_id');
            $table->string('nama_tahapan', 255);
            $table->integer('nilai')->nullable();
            $table->timestamps();

            $table->foreign('jaringan_id')->references('id')->on('jaringans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tahapans');
    }
};

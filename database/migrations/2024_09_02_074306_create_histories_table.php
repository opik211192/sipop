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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jaringan_id'); // ID jaringan
            $table->unsignedBigInteger('tahapan_id'); // ID tahapan
            $table->dateTime('tanggal'); // Tanggal penyimpanan history
            $table->text('data'); // Data dalam bentuk JSON
            $table->string('recommendation'); // Rekomendasi (SIAP OP, SIAP OP dengan Catatan, dll)
            $table->timestamps(); // Created at & Updated at

            // Foreign key constraints
            $table->foreign('jaringan_id')->references('id')->on('jaringans')->onDelete('cascade');
            $table->foreign('tahapan_id')->references('id')->on('tahapans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
};

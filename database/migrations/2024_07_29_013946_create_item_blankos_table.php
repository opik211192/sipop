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
        Schema::create('item_blankos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluasi_blanko_id');
            $table->string('nama_item');
            $table->enum('ada_tidak_ada', ['Ada', 'Tidak Ada']);
            $table->integer('kondisi')->nullable();
            $table->integer('fungsi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('evaluasi_blanko_id')->references('id')->on('evaluasi_blankos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_blankos');
    }
};

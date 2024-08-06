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
        Schema::create('evaluasi_blankos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahapan_id');
            $table->enum('jenis_blanko', ['Blanko 1A', 'Blanko 1B', 'Blanko 1C', 'Blanko 2', 'Blanko 3A', 'Blanko 3B', 'Blanko 3C', 'Blanko 3D']);
            $table->decimal('hasil_ada_tidak_ada', 5, 2)->nullable();
            $table->decimal('hasil_kondisi', 5, 2)->nullable();
            $table->decimal('hasil_fungsi', 5, 2)->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('evaluasi_blankos');
    }
};

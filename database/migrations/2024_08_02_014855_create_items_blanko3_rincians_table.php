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
        Schema::create('item_blanko3_rincians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_blanko3_id');
            $table->string('rincian');
            $table->decimal('ada_tidak_ada', 5, 2)->nullable();
            $table->decimal('bobot', 5, 2)->nullable();
            $table->decimal('kondisi', 5, 2)->nullable();
            $table->decimal('fungsi', 5, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();


            $table->foreign('item_blanko3_id')->references('id')->on('item_blanko3s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_blanko3_rincians');
    }
};

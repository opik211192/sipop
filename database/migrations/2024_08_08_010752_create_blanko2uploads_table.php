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
        Schema::create('blanko2_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_blanko_id')->nullable();
            $table->string('nama_file')->nullable();
            $table->timestamps();


            $table->foreign('item_blanko_id')->references('id')->on('item_blankos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blanko2uploads');
    }
};

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
       Schema::create('jaringans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->string('wilayah_sungai')->nullable();
            $table->enum('jenis', ['Air Tanah', 'Air Baku', 'Embung'])->nullable();
            $table->year('tahun')->nullable();
            $table->enum('satker', ['Satker Balai', 'Satker PJPA', 'Satker PJSA', 'Satker Bendungan'])->nullable();
            $table->string('tahapan')->nullable();
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('indonesia_provinces');
            $table->foreign('city_id')->references('id')->on('indonesia_cities');
            $table->foreign('district_id')->references('id')->on('indonesia_districts');
            $table->foreign('village_id')->references('id')->on('indonesia_villages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jaringans');
    }
};

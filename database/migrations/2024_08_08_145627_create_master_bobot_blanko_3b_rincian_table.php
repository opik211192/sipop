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
        Schema::create('master_bobot_blanko_3b_rincian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_bobot_blanko_3b_id');
            $table->string('rincian');
            $table->decimal('bobot', 5, 2);
            $table->timestamps();

            $table->foreign('master_bobot_blanko_3b_id')
                  ->references('id')
                  ->on('master_bobot_blanko_3b')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_bobot_blanko_3b_rincian');
    }
};

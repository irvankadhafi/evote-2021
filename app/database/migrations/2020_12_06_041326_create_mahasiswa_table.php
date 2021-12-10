<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim',9)->primary()->unique();
            $table->string('name');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('id_kandidat')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->foreign('id_kandidat')->references('id')->on('kandidat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}

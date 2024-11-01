<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('album_name');
            $table->string('artist_name');
            $table->foreignId('genre_id')->constrained(); // Zorg ervoor dat deze kolom ook bestaat in de genres tabel
            $table->date('release_date');
            $table->string('images');
            $table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     */public function down()
    {

    }

};

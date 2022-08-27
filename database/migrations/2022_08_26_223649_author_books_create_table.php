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

        Schema::create( 'authors_books' ,  function (Blueprint $table){
            $table->id();
            
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('books_id');

            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('books_id')->references('id')->on('books');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_books');
    }
};

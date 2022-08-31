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
        Schema::create( 'books' ,  function (Blueprint $table){

            $table->id();
            $table->string('title');
            $table->text('sinopse');
            $table->integer('pages');
            $table->string('cover_type');      
            $table->string('cover_photo');
            $table->unsignedBigInteger('publish_companies_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('publish_companies_id')->references('id')->on('publishing_companies');
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};

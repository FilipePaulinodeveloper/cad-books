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
            $table->string('book_photo');
            $table->unsignedBigInteger('publishing_company_id');
           
            $table->foreign('publishing_company_id')->references('id')->on('publishing_company');
            
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

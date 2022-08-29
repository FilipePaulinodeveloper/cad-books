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
            $table->string('sinopse');
            $table->integer('pages');
            $table->string('cover_type');      
            $table->unsignedBigInteger('publish_companies_id');
            
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
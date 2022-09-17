<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'authors';

    protected $fillable = [
      'name',
      'description',
    //   'author_photo',

    ];


    protected function authorPhoto(): Attribute

    {

        return Attribute::make(
            
            get:fn($value)=> 'http://' . $_SERVER['HTTP_HOST'] ."/storage/" . $value,
            
            

        );

    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

}

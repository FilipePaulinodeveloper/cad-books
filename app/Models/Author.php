<?php

namespace App\Models;

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
      'author_photo',

    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

}

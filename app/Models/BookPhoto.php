<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookPhoto extends Model
{
    use HasFactory;

    protected $table = 'photos_books';
    
    protected $fillable = [
      'photo',
      'is_thumb',      
    ];

    public function books()    
    {
        return $this->belongsTo(Book::class);  
    }

}

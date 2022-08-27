<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';

    protected $fillable = [

        'title',
        'sinopse',
        'pages',
        'cover_type',     

    ];
        
    public function author()    
    {
        return $this->belongsToMany(Author::class);
    }

    public function bookphoto()    
    {
        return $this->hasMany(BookPhoto::class );
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function publishCompany()
    {
        return $this->belongsTo(publishCompany::class);
    }
    
    

}

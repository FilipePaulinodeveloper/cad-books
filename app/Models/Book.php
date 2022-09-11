<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'books';

    protected $fillable = [

        'title',
        'sinopse',
        'pages',
        'cover_type',
        'book_photo',    
        'publishing_company_id', 
        
        

    ];
    protected function bookPhoto(): Attribute

    {

        return Attribute::make(
            
            get:fn($value)=> 'http://' . $_SERVER['HTTP_HOST'] ."/storage/" . $value,
            
            

        );

    }
        
    public function author()    
    {
        return $this->belongsToMany(Author::class);
    }   

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function publishCompanies()
    {
        return $this->belongsTo(publishCompany::class);
    }
    
    

}

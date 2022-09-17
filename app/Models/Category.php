<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        // 'category_photo',        
    ];   

    protected function categoryPhoto(): Attribute

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

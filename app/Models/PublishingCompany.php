<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishingCompany extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'publishing_company';

    protected $fillable = [
        'name',
        'description',
        'publishing_company_photo',
    ];

    protected function publishingCompanyPhoto(): Attribute

    {

        return Attribute::make(
            
            get:fn($value)=> 'http://' . $_SERVER['HTTP_HOST'] ."/storage/" . $value,
            
            

        );

    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
}

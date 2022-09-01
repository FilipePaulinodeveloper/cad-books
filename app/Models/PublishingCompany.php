<?php

namespace App\Models;

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

    public function books()
    {
        return $this->hasMany(Books::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishingCompany extends Model
{
    use HasFactory;
    
    protected $table = 'publishing_companies';

    protected $fillable = [
        'name'
    ];
    
    public function books()
    {
        return $this->hasMany(Books::class);
    }
}

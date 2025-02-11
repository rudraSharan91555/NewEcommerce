<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\URL;
class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'image',
        
    ];
       protected function Image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => URL::to(''.$value.'')
        );
    }
}
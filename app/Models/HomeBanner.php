<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\URL;

class HomeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'text', // ✅ 'name' hata ke 'text' add karein
        'link',
        'image',
    ];

    protected function Image(): Attribute
    {
        return Attribute::make(
            // get: fn($value) => $value ? URL::to('public/images/' . $value) : null
            get: fn ($value) => URL::to(''.$value.'')
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_type',
        'token',
        
    ];
    public $timestamps = true;
}

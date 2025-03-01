<!-- 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'product_id',
        'product_attr_id',
        'qty'
    ];

    protected $hidden = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->with('productAttributes');
    }
} -->
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'product_id',
        'product_attr_id',
        'qty'
    ];

    protected $hidden = ['id'];

    // Correct Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->with('productAttributes');
    }
}

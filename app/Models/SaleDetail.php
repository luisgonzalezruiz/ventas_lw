<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'quantity',
        'sale_id',
        'product_id'
    ];

    /**
     * Sale
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}

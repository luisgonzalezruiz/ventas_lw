<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'price',
        'stock',
        'alerts',
        'image',
        'category_id'
    ];

    /**
     * Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
/*     protected static function booted()
    {
        //Remove the image when delete object.
        static::deleted(function ($product) {
            Storage::disk('products')->delete($product->image);
        });
    } */

    public function scopeByBarcode($query, $barcode = '')
    {
        $query->where('barcode', $barcode);
    }

    public function scopeOrCategoryName($query, $categoryName = '')
    {
        $query->orWhereHas('category', function($query) use ($categoryName) {
            $query->where('name', 'like', "%$categoryName%");
        });
    }

    public function canDelete()
    {
        return true;
    }
}

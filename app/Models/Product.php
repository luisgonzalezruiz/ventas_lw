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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

/*  protected static function booted()
    {
        //Remove the image when delete object.
        static::deleted(function ($product) {
            Storage::disk('products')->delete($product->image);
        });
    } */

/*  public function scopeByBarcode($query, $barcode = '')
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
    } */

}

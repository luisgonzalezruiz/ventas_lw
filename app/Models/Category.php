<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //Remove the image when delete object.
        static::deleted(function ($category) {
            Storage::disk('categories')->delete($category->image ?? '');
        });
    }

    /**
     * Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function canDelete()
    {
        return !$this->products()->exists();
    }
}

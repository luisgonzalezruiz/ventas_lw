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

    /*protected static function booted()
    {
        //Remove the image when delete object.
        static::deleted(function ($category) {
            Storage::disk('categories')->delete($category->image ?? '');
        });
    } */


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // este accesor lo usamos en todo
    public function getImagenAttribute(){
        // asi valida la ruta a partir del public/storage/categories/imagen.jpg
        // asi valida la ruta a partir del public/storage/categories/imagen.jpg
        if($this->image==null) {
            return 'noimg.png';
        }

        if(file_exists('storage/' . $this->image))
            return $this->image;
        else
            // esta imagen esta en la carpeta storage que es la publica
            return 'noimg.png';
    }

    public function canDelete()
    {
        return !$this->products()->exists();
    }
}

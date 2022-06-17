<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Denomination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'value',
        'image'
    ];

    public function getImagenAttribute(){

        if($this->image==null) {
            return 'noimg.png';
        }

        if(file_exists('storage/' . $this->image))
            return $this->image;
        else
            // esta imagen esta en la carpeta storage que es la publica
            return 'noimg.png';
    }

    /*
    protected static function booted()
    {
        //Remove the image when delete object.
        static::deleted(function ($denomination) {
            Storage::disk('denominations')->delete($denomination->image);
        });
    }

    public function canDelete()
    {
        return true;
    }
    */
}

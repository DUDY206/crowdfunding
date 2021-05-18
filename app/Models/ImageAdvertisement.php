<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ImageAdvertisement extends Model
{
    use HasFactory;

    protected $table = 'image_advertisements';

    protected $fillable = [
        'img',
        'url',
        'sort_level',
        'status',
    ];

    protected $appends = [
        'url_folder_img'
    ];

    public function getUrlFolderImgAttribute()
    {
        return 'storage/advertisement/' . $this->img;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('h:m:s d/m/Y', strtotime($value));
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($image){
            File::delete($image->img);
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'img_cover',
        'description',
        'level',
        'status',
    ];

    protected $with = [
        'lang_name',
        'lang_slug',
        'lang_description'
    ];

    protected $hidden = [
        'name',
        'slug',
        'description'
    ];

    protected $appends = [
        'status_format',
    ];

    public function getStatusFormatAttribute()
    {
        $method = '';

        if ($this->status == 0) {
            $method = 'Ẩn';
        }

        if ($this->status == 1) {
            $method = 'Hiển thị';
        }

        return $method;
    }

    public function lang_name()
    {
        return $this->hasOne(Language::class, 'id', 'name');
    }

    public function lang_slug()
    {
        return $this->hasOne(Language::class, 'id', 'slug');
    }

    public function lang_description()
    {
        return $this->hasOne(Language::class, 'id', 'description');
    }

    public static function getLangArray()
    {
        return [
            'name',
            'description',
        ];
    }

    public function company_invest()
    {
        return $this->belongsToMany(CompanyInvest::class, 'category_has_invest', 'category_id', 'invest_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($categories) {
            $lang_slug = Language::create([
                'vi' => Str::slug($categories->lang_name->vi).'-'.$categories->id,
                'en' => Str::slug($categories->lang_name->en).'-'.$categories->id,
                'field' => 'category.slug'
            ]);
            $categories->slug = $lang_slug->id;
            $categories->save();
        });

        static::saved(function($categories) {
            $currentCategory = Category::findOrFail($categories->id);
            $lang_slug = Language::findOrFail($categories->slug);

            $lang_slug->update([
                'vi' => Str::slug($currentCategory->lang_name->vi).'-'.$categories->id,
                'en' => Str::slug($currentCategory->lang_name->en).'-'.$categories->id,
            ]);
            $lang_slug->save();
        });

        static::deleting(function($categories) {
            if ($categories->logo != null) {
                $img_url = public_path('storage/categories/logo/' . $categories->logo);
                unlink($img_url);
            }

            if ($categories->img_cover != null) {
                $img_url = public_path('storage/categories/cover/' . $categories->img_cover);
                unlink($img_url);
            }

            $categories->lang_name->delete();
            $categories->lang_slug->delete();
            $categories->lang_description->delete();
        });
    }
}

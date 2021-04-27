<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'name',
        'img_url',
        'description',
        'content',
        'total_like',
    ];

    protected $with = ['lang_name', 'lang_description', 'lang_content', 'company_invest'];

    protected $hidden = ['name', 'description', 'content', 'pivot'];

    protected $appends = ['created_date'];

    public function lang_name()
    {
        return $this->hasOne(Language::class, 'id', 'name');
    }

    public function lang_description()
    {
        return $this->hasOne(Language::class, 'id', 'description');
    }

    public function lang_content()
    {
        return $this->hasOne(Language::class, 'id', 'content');
    }

    public static function getLangArray()
    {
        return [
            'name',
            'description',
            'content',
        ];
    }

    public function company_invest()
    {
        return $this->belongsToMany(CompanyInvest::class, 'invest_has_news', 'news_id', 'invest_id')->withPivot('invest_id');
    }

    public function getCreatedDateAttribute()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($news) {
            if ($news->img_url != null) {
                $img_url = public_path('storage/news/' . $news->img_url);
                unlink($img_url);
            }

            $news->lang_name->delete();
            $news->lang_description->delete();
            $news->lang_content->delete();

            if ($news->company_invest != null) $news->company_invest()->detach();
        });
    }
}

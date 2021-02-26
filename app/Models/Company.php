<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = ['name','description','img_url','video_url','legal_name','founded','company_type','total_employees','website','account_id','location'];

    protected $hidden = ['name','description','slug','company_type','location'];

    protected $with = ['lang_name','lang_description','lang_slug','lang_company_type','lang_location'];

    protected $appends = ['path_img_url'];

    public function lang_name(){
        return $this->hasOne(Language::class,'id','name');
    }

    public function lang_description(){
        return $this->hasOne(Language::class,'id','description');
    }

    public function lang_slug(){
        return $this->hasOne(Language::class,'id','slug');
    }

    public function lang_company_type(){
        return $this->hasOne(Language::class,'id','company_type');
    }

    public function lang_location(){
        return $this->hasOne(Language::class,'id','location');
    }

    public function company_invest(){
        return $this->hasMany(CompanyInvest::class,'company_id','id');
    }

    public function owner(){
        return $this->belongsTo(User::class,'account_id','id');
    }

    //extend attribute
    public function getPathImgUrlAttribute(){
        return '/storage/company/img/' . $this->img_url;
    }
    protected static function boot()
    {
        parent::boot();
        static::created(function($company){
            $lang_slug = Language::create([
                'vi' => Str::slug($company->lang_name->vi).'-'.$company->id,
                'en' => Str::slug($company->lang_name->en).'-'.$company->id,
                'field' => 'companies.slug'
            ]);
            $company->slug = $lang_slug->id;
            $company->save();
        });
        static::saved(function($company){
            $lang_slug = Language::findOrFail($company->slug);
            $lang_slug->update([
                'vi' => Str::slug($company->lang_name->vi).'-'.$company->id,
                'en' => Str::slug($company->lang_name->en).'-'.$company->id,
            ]);
            $lang_slug->save();
        });
        static::deleting(function($company){
            $company->lang_name->delete();
            $company->lang_slug->delete();
            if($company->description != null) $company->lang_description->delete();
            if($company->company_type != null) $company->lang_company_type->delete();
        });
    }

    //custom extend method
    public function findCompanyBySlug($slug){
        $lang_slug = Language::where('field','companies.slug')->where(app()->getLocale(),$slug)->firstOrFail();
        return $this->where('slug',$lang_slug->id)->firstOrFail();
    }
}

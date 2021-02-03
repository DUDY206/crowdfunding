<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvestMutableField extends Model
{
    use HasFactory;

    public $lang_array = ['title','lang_content'];

    protected $table = 'invest_mutable_fields';

    public $timestamps = false;

    protected $fillable = ['invest_id','title','content','position'];

    protected $hidden = ['title','content','id','invest_id'];

    protected $with = ['lang_title','lang_content'];

    //relationship
    public function company_invest(){
        return $this->belongsTo(CompanyInvest::class,'invest_id','id');
    }

    public function lang_title(){
        return $this->hasOne(Language::class,'id','title');
    }

    public function lang_content(){
        return $this->hasOne(Language::class,'id','content');
    }

    //extend function
    public static function getLangArray(){
        return ['title','content'];
    }

    //boot
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($invest_mutable_fields){
            $invest_mutable_fields->lang_title->delete();
            $invest_mutable_fields->lang_content->delete();
        });
    }
}

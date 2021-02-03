<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestImmutableField extends Model
{
    use HasFactory;

    protected $table = 'invest_immutable_fields';

    public $timestamps = false;

    protected $fillable = ['invest_id','hight_light','overview_specialized','overview_company','financial_before','financial_after'];

    protected $hidden = ['hight_light','overview_specialized','overview_company','financial_before','financial_after','id','invest_id'];

    protected $with = ['lang_hight_light','lang_overview_specialized','lang_overview_company','lang_financial_before','lang_financial_after'];

    //relationship
    public function company_invest(){
        return $this->belongsTo(CompanyInvest::class,'invest_id','id');
    }

    public function lang_hight_light(){
        return $this->hasOne(Language::class,'id','hight_light');
    }

    public function lang_overview_specialized(){
        return $this->hasOne(Language::class,'id','overview_specialized');
    }

    public function lang_overview_company(){
        return $this->hasOne(Language::class,'id','overview_company');
    }

    public function lang_financial_before(){
        return $this->hasOne(Language::class,'id','financial_before');
    }

    public function lang_financial_after(){
        return $this->hasOne(Language::class,'id','financial_after');
    }

    //extend function
    public static function getLangArray(){
        return ['hight_light','overview_specialized','overview_company','financial_before','financial_after'];
    }

    //boot
    protected static function boot()
    {
        parent::boot();
        static::deleting(function($invest_immutable_fields){
            if($invest_immutable_fields->lang_hight_light != null) $invest_immutable_fields->lang_hight_light->delete();
            if($invest_immutable_fields->lang_overview_specialized != null) $invest_immutable_fields->lang_overview_specialized->delete();
            if($invest_immutable_fields->lang_overview_company != null) $invest_immutable_fields->lang_overview_company->delete();
            if($invest_immutable_fields->lang_financial_before != null) $invest_immutable_fields->lang_financial_before->delete();
            if($invest_immutable_fields->lang_financial_after != null) $invest_immutable_fields->lang_financial_after->delete();
        });
    }
}

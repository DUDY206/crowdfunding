<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestType extends Model
{
    use HasFactory;

    protected $table = 'invest_types';

    protected $fillable = ['name','short_description'];

    protected $hidden = ['name','short_description'];

    protected $with = ['lang_name','lang_short_description'];

    public $timestamps = false;
    //relationship
    public function lang_name(){
        return $this->hasOne(Language::class,'id','name');
    }

    public function lang_short_description(){
        return $this->hasOne(Language::class,'id','short_description');
    }

    public function invest(){
        return $this->belongsToMany(CompanyInvest::class, 'invest_has_types', 'invest_type_id', 'invest_id');
    }
    //extend attribute
//    public function getImgPathAttribute(){
//        return $this->
//    }

    //static function
    public static function getLangArray(){
        return ['name','short_description'];
    }
}

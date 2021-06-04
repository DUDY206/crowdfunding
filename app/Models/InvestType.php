<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestType extends Model
{
    use HasFactory;

    protected $table = 'invest_types';

    protected $fillable = [
        'name',
        'short_description',
        'price',
    ];

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

    public function contract_input_field(){
        return $this->belongsToMany(ContractInputField::class, 'contract_has_input_field', 'invest_type_id', 'contract_field_id');
    }

    public function contract_template(){
        return $this->hasMany(ContractTemplate::class, 'invest_type_id', 'id');
    }

    //extend attribute
//    public function getImgPathAttribute(){
//        return $this->
//    }

    //static function
    public static function getLangArray(){
        return ['name','short_description'];
    }

    public function getPriceAttribute($value)
    {
        return $value + 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($investType) {
            $investType->lang_name->delete();
            $investType->lang_short_description->delete();
            $investType->contract_input_field()->detach();
            $investType->contract_template()->delete();
        });
    }
}

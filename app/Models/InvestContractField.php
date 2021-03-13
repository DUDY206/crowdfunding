<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestContractField extends Model
{
    use HasFactory;

    protected $table =  'invest_contract_field';

    protected $fillable = [
        'field',
    ];

    protected $with = [
        'lang_field',
    ];

    public $timestamps = false;

    protected $hidden = ['field'];

    public function lang_field(){
        return $this->hasOne(Language::class,'id','field');
    }

    public function company_invest(){
        return $this->belongsToMany(CompanyInvest::class,'invest_has_contract_field','invest_contract_field_id','invest_id')->withPivot('value');
    }

    public static function getLangArray(){
        return ['field'];
    }
}

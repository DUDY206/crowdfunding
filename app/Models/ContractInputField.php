<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractInputField extends Model
{
    use HasFactory;

    protected $table = "contract_input_fields";

    public $timestamps = false;

    protected $with = ['lang_field'];

    protected $hidden = ['field','pivot'];

    protected $fillable = ['field'];

    public function lang_field(){
        return $this->hasOne(Language::class,'id','field');
    }

    public function contract_type(){
        return $this->belongsToMany(InvestType::class, 'contract_has_input_field', 'contract_field_id', 'invest_type_id');
    }

    //extend function
    public static function getLangArray(){
        return ['field'];
    }
}

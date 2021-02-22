<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risks extends Model
{
    use HasFactory;

    protected $table = 'risks';

    protected $fillable = ['invest_id','risk','solution'];

    protected $with = ['lang_risk','lang_solution'];

    protected $hidden = ['risk','solution'];

    public $timestamps = false;

    public function lang_risk(){
        return $this->hasOne(Language::class,'id','risk');
    }

    public function lang_solution(){
        return $this->hasOne(Language::class,'id','solution');
    }

    public function investment(){
        return $this->belongsTo(CompanyInvest::class,'invest_id','id');
    }

    public static function getLangArray(){
        return ['risk','solution'];
    }
}

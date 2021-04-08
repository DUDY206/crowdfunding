<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = ['invest_id','question','answer'];

    protected $with = ['lang_question','lang_answer'];

    protected $hidden = ['question','answer'];

    public $timestamps = false;

    public function lang_question(){
        return $this->hasOne(Language::class, 'id', 'question');
    }

    public function lang_answer(){
        return $this->hasOne(Language::class, 'id', 'answer');
    }

    public function investment(){
        return $this->belongsTo(CompanyInvest::class,'invest_id','id');
    }

    public static function getLangArray(){
        return ['question','answer'];
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function($faqs){
            $faqs->lang_question->delete();
            $faqs->lang_answer->delete();
        });
    }
}

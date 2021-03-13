<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTemplate extends Model
{
    use HasFactory;

    protected $table = 'contract_templates';

    protected $fillable = ['input_label','invest_type_id','template','name'];

    public function invest_type(){
        return $this->belongsTo(InvestType::class,'invest_type_id','id');
    }

    protected $hidden = ['created_at','updated_at'];

    protected $appends = ['diff_created_at','diff_updated_at'];

    public function getDiffCreatedAtAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getDiffUpdatedAtAttribute(){
        return $this->updated_at->diffForHumans();
    }

}

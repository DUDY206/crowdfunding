<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompanyInvest extends Model
{
    use HasFactory;

    protected $table = 'company_investments';

    protected $fillable = ['name','short_description','img_url','video_url','min_invest','valuation_cap','location','status','company_id','total_follow'];

    protected $hidden = ['name','short_description','location'];

    protected $with = ['lang_name','lang_short_description','lang_location','lang_slug','company','immutable_field','mutable_field','faq','risks','social_comment','invest_type','contract_field'];

    protected $appends = ['company_name','path_img_url','is_like_by_current_user','array_invest_type','total_invested_money','total_investor','date_expired_diff'];

    //LANG RELATION SHIP
    public function lang_slug(){
        return $this->hasOne(Language::class,'id','slug');
    }

    public function lang_name(){
        return $this->hasOne(Language::class,'id','name');
    }

    public function lang_short_description(){
        return $this->hasOne(Language::class,'id','short_description');
    }

    public function lang_location(){
        return $this->hasOne(Language::class,'id','location');
    }

    //ATTRIBUTE RELATION SHIP
    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function faq(){
        return $this->hasMany(FAQ::class,'invest_id','id');
    }

    public function risks(){
        return $this->hasMany(Risks::class,'invest_id','id');
    }

    public function immutable_field(){
        return $this->hasOne(InvestImmutableField::class,'invest_id','id');
    }

    public function mutable_field(){
        return $this->hasMany(InvestMutableField::class,'invest_id','id');
    }

    public function social_comment(){
        return $this->hasMany(SocialComment::class,'invest_id','id');
    }

    public function be_followed(){
        return $this->morphToMany(User::class,'model','account_like_models','model_id','account_id')->withTimestamps();
    }

    public function invest_type(){
        return $this->belongsToMany(InvestType::class, 'invest_has_types', 'invest_id', 'invest_type_id');
    }

    public function contract_field(){
        return $this->belongsToMany(InvestContractField::class,'invest_has_contract_field','invest_id','invest_contract_field_id')->withPivot('value');
    }

    public function order(){
        return $this->hasMany(Order::class, 'invest_id', 'id');
    }

    //attribute
    public function getTotalInvestedMoneyAttribute(){
        return $this->order->where('payment_status', 3)->sum('amount');
    }

    public function getTotalInvestorAttribute(){
        return count($this->order->where('payment_status',3));
    }

    public function getDateExpiredDiffAttribute(){
        // return round((strtotime($this->expired_date)-time())/(60*60*24));

        $date = round((strtotime($this->expired_date)-time())/(60*60*24));

        if ($date < 0) {
            return 'Expired ' . abs($date);
        } else {
            return $date;
        }
    }

    public function getCompanyNameAttribute(){
        return $this->company->lang_name;
    }

    public function getPathImgUrlAttribute(){
        return '/storage/companyInvest/img/' . $this->img_url;
    }

    public function getArrayInvestTypeAttribute(){
        return $this->invest_type->pluck('id');
    }

    public function getIsLikeByCurrentUserAttribute(){
        $current_user = $GLOBALS['request']->user('api');
        if($current_user === null){
            return false;
        }
        $like = count(DB::table('account_like_models')->where('account_id',$current_user->id)->where('model_type',CompanyInvest::class)->where('model_id',$this->id)->get());
        if($like>0)
            return true;
        return false;
    }

    //extend function
    public static function getLangArray(){
        return ['name','short_description','location'];
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function($company_invest){
            $lang_slug = Language::create([
                'vi' => Str::slug($company_invest->lang_name->vi).'-'.$company_invest->id,
                'en' => Str::slug($company_invest->lang_name->en).'-'.$company_invest->id,
                'field' => 'company-invest.slug'
            ]);
            $company_invest->slug = $lang_slug->id;
            $company_invest->save();
        });
        static::saved(function($company_invest){
            $lang_slug = Language::findOrFail($company_invest->slug);
            $lang_slug->update([
                'vi' => Str::slug($company_invest->lang_name->vi).'-'.$company_invest->id,
                'en' => Str::slug($company_invest->lang_name->en).'-'.$company_invest->id,
            ]);
            $lang_slug->save();
        });
        static::deleting(function($company_invest){
            $company_invest->lang_name->delete();
            $company_invest->lang_slug->delete();
            if($company_invest->short_description != null) $company_invest->lang_short_description->delete();
            if($company_invest->location != null) $company_invest->lang_location->delete();
            if($company_invest->immutable_field != null) $company_invest->immutable_field->delete();
            foreach ($company_invest->mutable_field as $field){
                $field->delete();
            }
        });
    }
}
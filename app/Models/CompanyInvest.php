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

    protected $fillable = [
        'name',
        'short_description',
        'img_url',
        'video_url',
        'min_invest',
        'valuation_cap',
        'location',
        'status',
        'company_id',
        'total_follow'
    ];

    protected $hidden = [
        'name',
        'short_description',
        'location',
        'order'
    ];

    protected $with = [
        'lang_name',
        'lang_short_description',
        'lang_location',
        'lang_slug',
        // 'company',
        // 'immutable_field',
        // 'mutable_field',
        // 'faq',
        // 'risks',
        // 'social_comment',
        // 'invest_type',
        // 'contract_field'
    ];

    protected $appends = [
        // 'company_name',
        'path_img_url',
        // 'is_like_by_current_user',
        // 'array_invest_type',
        // 'total_invested_money',
        'total_investor',
        // 'date_expired_diff',
        // 'user_in_invest'
    ];

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

    public function order()
    {
        return $this->hasMany(Order::class, 'invest_id', 'id');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'invest_has_news', 'invest_id', 'news_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_has_invest', 'invest_id', 'category_id');
    }

    // public function getNewsOfInvestAttribute()
    // {
    //     return $this->belongsToMany(News::class, 'invest_has_news', 'invest_id', 'news_id');
    // }

    //attribute
    public function getTotalInvestedMoneyAttribute()
    {
        return DB::table('orders')->where('invest_id', $this->id)->where('payment_status', 3)->sum('amount') * 1;
    }

    public function getTotalInvestorAttribute()
    {
        return DB::table('orders')->where('invest_id', $this->id)->where('payment_status', 3)->count();
    }

    public function getDateExpiredDiffAttribute(){
        // return round((strtotime($this->expired_date)-time())/(60*60*24));

        $date = round((strtotime($this->expired_date)-time())/(60*60*24));

        return $date;
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

    public function getMinInvestAttribute($value)
    {
        return $value + 0;
    }

    public function getValuationCapAttribute($value)
    {
        return $value + 0;
    }

    public function getUserInInvestAttribute()
    {
        $userId = [];

        foreach ($this->order as $orderItem) {
            array_push($userId, $orderItem->account_id);
        }

        $userId = array_unique($userId, 0);
        $users = User::whereIn('id', $userId)->orderByDesc('id')->paginate(6, [
            'slug',
            'full_name',
            'avatar',
            'description',
            'slogan',
            'created_at'
        ]);

        return $users;
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
            $image = public_path('storage/companyInvest/img/' . $company_invest->img_url);
            unlink($image);

            $company_invest->lang_name->delete();

            $company_invest->lang_slug->delete();

            if ($company_invest->short_description != null) $company_invest->lang_short_description->delete();

            if ($company_invest->location != null) $company_invest->lang_location->delete();

            if ($company_invest->immutable_field != null) $company_invest->immutable_field->delete();

            foreach ($company_invest->mutable_field as $field) {
                $field->delete();
            }

            if ($company_invest->contract_field != null) $company_invest->contract_field()->detach();
            if ($company_invest->invest_type != null) $company_invest->invest_type()->detach();

            foreach ($company_invest->faq as $field) {
                $field->delete();
            }

            foreach ($company_invest->risks as $field) {
                $field->delete();
            }
        });
    }
}

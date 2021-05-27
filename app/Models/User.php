<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    protected $table = 'account';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'slug',
        'full_name',
        'password',
        'email',
        'phone_number',
        'citizen_identification',
        'card_date',
        'card_address',
        'current_address',
        'date_of_birth',
        'avatar',
        'cover_photo',
        'description',
        'slogan',
        'is_verify',
        'is_reliable_investor',
        'code_email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_path',
        'date_created_at',
        'cover_photo_path',
        // 'is_like_by_current_user'
    ];

    //RELATIONSHIP
    public function like_comment()
    {
        return $this->morphedByMany(SocialComment::class,'model','account_like_models','account_id')->withTimestamps();
    }

    public function like_investment()
    {
        return $this->morphedByMany(CompanyInvest::class,'model','account_like_models','account_id')->withTimestamps();
    }

    public function follow_user()
    {
        return $this->morphedByMany(User::class,'model','account_like_models','account_id')->withTimestamps();
    }

    public function be_followed()
    {
        return $this->morphToMany(User::class,'model','account_like_models','model_id','account_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(SocialComment::class, 'account_id', 'id');
    }

    public function company()
    {
        return $this->hasMany(Company::class, 'account_id', 'id');
    }

    //EXTEND ATTRIBUTE
    public function getAvatarPathAttribute()
    {
        $base_name = $this->avatar;

        if ($base_name === null) {
            return '/admin/img/default_avatar.png';
        } else {
            return '/storage/investor/avatar/' . $base_name;
        }
    }

    public function getCoverPhotoPathAttribute()
    {
        $base_name = $this->cover_photo;

        if ($base_name === null) {
            return null;
        } else {
            return '/storage/investor/cover_photo/'.$base_name;
        }
    }

    public function getDateCreatedAtAttribute()
    {
        $created_at = $this->created_at;

        return date_format($created_at, "d/m/Y");
    }

    public function getIsLikeByCurrentUserAttribute()
    {
        $current_user = $GLOBALS['request']->user('api');
        if ($current_user === null) {
            return false;
        }

        $like = count(DB::table('account_like_models')->where('account_id',$current_user->id)->where('model_type',User::class)->where('model_id',$this->id)->get());
        if ($like > 0)
            return true;

        return false;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'account_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->slug = Str::slug($user->user_name) . '-' . $user->id;
            $user->save();
        });

        static::deleting(function ($user) {
            if ($user->avatar != null) {
                $avatar = public_path('storage/investor/avatar/' . $user->avatar);
                unlink($avatar);
            }

            if ($user->cover_photo != null) {
                $cover_photo = public_path('storage/investor/cover_photo/' . $user->cover_photo);
                unlink($cover_photo);
            }

            $user->like_comment()->detach();
            $user->like_investment()->detach();
            $user->follow_user()->detach();
            $user->be_followed()->detach();

            foreach ($user->comments as $field) {
                $field->delete();
            }
        });
    }
}

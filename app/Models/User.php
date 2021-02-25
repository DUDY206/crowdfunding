<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

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
        'full_name',
        'password',
        'email',
        'phone_number',
        'date_of_birth',
        'avatar',
        'cover_photo',
        'description',
        'slogan',
        'is_verify',
        'is_reliable_investor',
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

    protected $appends = ['avatar_path','date_created_at','cover_photo_path'];

    public function like_comment()
    {
        return $this->morphedByMany(SocialComment::class,'model','account_like_models','account_id')->withTimestamps();
    }

    public function getAvatarPathAttribute(){
        $base_name = $this->avatar;
        if($base_name === null){
            return '/admin/img/default_avatar.png';
        }else{
            return '/storage/investor/avatar/'.$base_name;
        }
    }

    public function getCoverPhotoPathAttribute(){
        $base_name = $this->cover_photo;
        if($base_name === null){
            return null;
        }else{
            return '/storage/investor/cover_photo/'.$base_name;
        }
    }

    public function getDateCreatedAtAttribute(){
        $created_at = $this->created_at;
        return date_format($created_at,"Y/m");
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function($user){
            $user->slug = Str::slug($user->user_name).'-'.$user->id;
            $user->save();
        });
        static::updated(function($user){
            $user->slug = Str::slug($user->user_name).'-'.$user->id;
            $user->save();
        });
    }
}

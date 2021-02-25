<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'user_name',
        'full_name',
        'password',
        'email',
        'phone_number',
        'avatar'
    ];

    protected $appends = ['avatar_path'];

    protected $table = 'admins';

    protected $guarded = 'admin';

    public function getAvatarPathAttribute(){
        $base_name = $this->avatar;
        if($base_name === null){
            return '/admin/img/default_avatar.png';
        }else{
            return '/storage/admin/avata/'.$base_name;
        }
    }

}

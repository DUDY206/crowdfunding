<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SocialComment extends Model
{
    use HasFactory;

    protected $table = 'social_comments';

    protected $fillable = [
        'content',
        'account_id',
        'invest_id',
        'reply_comment_id'
    ];

    protected $with = [
        // 'user',
        'reply_comments'
    ];

    protected $appends = [
        'diff_created_at',
        'is_like_by_current_user',
        'total_liked'
    ];

    public function user(){
        return $this->belongsTo(User::class,'account_id','id');
    }

    public function reply_comments(){
        return $this->hasMany(SocialComment::class,'reply_comment_id','id');
    }

    public function getDiffCreatedAtAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function is_liked(){
        return $this->morphToMany(User::class,'model','account_like_models','model_id','account_id')->withTimestamps();
    }

    public function getIsLikeByCurrentUserAttribute(){
        $current_user = $GLOBALS['request']->user('api');
        if($current_user === null){
            return false;
        }
        $like = count(DB::table('account_like_models')->where('account_id',$current_user->id)->where('model_type',SocialComment::class)->where('model_id',$this->id)->get());
        if($like>0)
            return true;
        return false;
    }

    public function getTotalLikedAttribute(){
        return count($this->is_liked);
    }
}

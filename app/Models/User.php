<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Str;
use Auth;
// Authenticatable  是授权相关功能的引用
class User extends Authenticatable
{
    // 消息通知相关功能引用
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // 指明要交互的数据库表
    protected $table = 'users';
    // 过滤用户提交的字段
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // 敏感信息隐藏
    protected $hidden = [
        'password', 'remember_token',
    ];
    //监听 create
    // boot  方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。
    public static function boot()
    {
        parent::boot();

        static::creating(function($user) {
            $user->activation_token = Str::random(10);
        });
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /*
    头像
    */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));//trim提出前后空白,然后转小写，然后md5转码
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
    /**
    *获取微博动态,自己和关注者的
    */
    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Status::whereIn('user_id', $user_ids)
                                ->with('user')
                                ->orderBy('created_at', 'desc');
        // Laravel 提供的 查询构造器  whereIn  方法取出所有用户的微博动态并进行倒序排序；

        // 预加载  with  方法，预加载避免了  N+1 查找的问题 ，大大提高了查询效率。 N+1 问题  的例子可以阅读此文档 Eloquent 模型关系预加载 。

        // return $this->statuses()
        //                 ->orderBy('created_at', 'desc');
    }

    /*
    *关注被关注的人
    */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }
    public function followings()
    {
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }
    /*
    关注和取消关注按钮
    */
    public function follow($user_ids)
    {
        //如果不是数组，没有必要 compact 方法。
        if( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);//方法会自动获取 id
    }
    public function unfollow($user_ids)
    {
        if( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
    //判断是否关注
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}

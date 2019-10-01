<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}

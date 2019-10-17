<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //指定可以赋值的字段
    protected $fillable = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

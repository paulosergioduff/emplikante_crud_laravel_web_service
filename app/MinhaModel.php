<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MinhaModel extends Model
{
    protected $fillable = ['name', 'login'];
    protected $guarded = ['user_id', 'created_at', 'update_at'];
    protected $table = 'users';
}

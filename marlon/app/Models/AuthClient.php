<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthClient extends Model
{
    protected $table = 'auth_clients';

    protected $fillable = ['user_id', 'api_key', 'token', 'token_expire'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}

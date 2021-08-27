<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $fillable = ['name', 'email', 'password'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }


    public static function make($params)
    {

        self::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => $params['password']
        ]);
        echo 'Dentro do make do User';
    }
}

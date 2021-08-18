<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $fillable = ['fullname', 'phone', 'email', 'note', 'id_user', 'id_address', 'id_category'];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function make($params)
    {
        self::create([
            'fullname' => $params->fullName,
            'phone' => $params->phone,
            'email' => $params->email,
            'note' => $params->note,
            'id_user' => $params->id_user,
            'id_address' => $params->id_address,
            'id_category' => $params->id_category
        ]);

        echo 'Contato cadastrado';
    }
}

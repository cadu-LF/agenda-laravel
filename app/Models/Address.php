<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $fillable = ['cep', 'street', 'neighborhood', 'city', 'state', 'country'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    public static function make($params)
    {
        self::create([
            'cep' => $params->cep,
            'street' => $params->street,
            'neighborhood' => $params->neighborhood,
            'city' => $params->city,
            'state' => $params->state
        ]);

        return self::all();
    }
}

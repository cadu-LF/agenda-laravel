<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['description'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public static function make($params)
    {
        self::create([
            'description' => $params->description
        ]);
    }
}

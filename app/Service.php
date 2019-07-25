<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 
        'price'
    ];

	public function doctors()
    {
        return $this->belongsToMany('App\Doctor');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 
        'phone', 
        'address', 
        'user_id'
    ];

    public function services()
    {
        return $this->belongsToMany('App\Service');
    }

    public function provides_service($service)
	{
		return $this->services()->where('service_id', $service)->exists();
	}
	
	public function working_hours()
	{
		return $this->hasMany('App\WorkingHour', 'doctor_id');
	}
	
	public function is_working($date) {
		return $this->working_hours->where('date', '=', $date)->first();
	}
	
	public function service_info($service)
	{
		return $this->services()->where('service_id', $service)->first();
	}

	public function users()
	{
		return $this->belongsTo(User::class, 'user_id');
    }
}

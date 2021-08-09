<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private function dateFormat($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('Y-m-d');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = Str::upper($value);
    }

    public function setMiddlenameAttribute($value)
    {
        $this->attributes['middlename'] = Str::upper($value);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = Str::upper($value);
    }

    public function getBirthdayAttribute($value)
    {
        return $this->dateFormat($value);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function getFullnameAttribute($value)
    {
        $middlename = $this->middlename ? " " . $this->middlename[0] . "." : null;
        return "{$this->lastname}, {$this->firstname}{$middlename}";
    }
}

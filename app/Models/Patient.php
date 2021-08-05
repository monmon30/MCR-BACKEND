<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = Str::upper($value);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = Str::upper($value);
    }

    public function setMiddlenameAttribute($value)
    {
        $this->attributes['middlename'] = Str::upper($value);
    }

    public function setSuffixAttribute($value)
    {
        $this->attributes['suffix'] = Str::upper($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = Str::upper($value);
    }

    public function setSexAttribute($value)
    {
        $this->attributes['sex'] = Str::upper($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullnameAttribute($value)
    {
        $middlename = $this->middlename ? " " . $this->middlename[0] . "." : null;
        return "{$this->lastname}, {$this->firstname}{$middlename}";
    }

    public function getGeneratedPatientApiKeyAttribute($user)
    {
        return Str::random(20) . "$" . $this->id . "-" . Str::random(10);
    }

    public static function checkPatientid($encryptedVal)
    {
        return Str::between($encryptedVal, '$', '-');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}

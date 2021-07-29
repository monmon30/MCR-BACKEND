<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

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
}

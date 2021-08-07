<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    private function dateFormat($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->format('Y-m-d');
    }

    private function dateDayDateFormat($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->toDayDateTimeString();
    }

    public function getScheduleAttribute($value)
    {
        return $this->dateDayDateFormat($value);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getDoneAttribute($value)
    {
        return boolval($value);
    }

}

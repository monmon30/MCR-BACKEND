<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    private function dateDayDateFormat($value)
    {
        return is_null($value) ? null : Carbon::parse($value)->toDayDateTimeString();
    }

    public function getConsultationDateAttribute()
    {
        return $this->dateDayDateFormat($this->created_at);
    }
}

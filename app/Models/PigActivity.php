<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PigActivity extends Model
{
    protected $fillable = [
        'pig_id',
        'user_id',
        'type',
        'action',
        'details',
        'is_critical_alert',
        'admin_response',
        'new_health_status',
        'new_feeding_status',
        'acknowledged_at',
        'acknowledged_by',
    ];

    protected $casts = [
        'is_critical_alert' => 'boolean',
        'acknowledged_at' => 'datetime',
    ];

    public function pig()
    {
        return $this->belongsTo(Pig::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acknowledgedBy()
    {
        return $this->belongsTo(User::class, 'acknowledged_by');
    }

    public function scopeUnacknowledgedAlerts($query)
    {
        return $query->where('is_critical_alert', true)->whereNull('acknowledged_at');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $table = 'problems';

    protected $fillable = [
        'level',
        'site',
        'flag',
        'requests',
        'solutions',
        'company_id',
        'group_id',
        'technician_id',
        'category_id',
        'request_by',
        'sla_id',
        'priority_id',
        'status',
        'name',
        'root_cause',
        'content',
        'attachments',
        'hidden',

        'response_time_estimate',
        'response_time_estimate_datetime',
        'response_time',
        'response_time_datetime',
        'response_time_late',
        'late_response_reason',

        'resolve_time_estimate',
        'resolve_time_estimate_datetime',
        'resolve_time',
        'resolve_time_datetime',
        'resolve_time_late',
        'late_resolve_reason',

        'overdue_status',

        'pending_time',
        'pending_reason',

        'active_date',
        'last_reply',
        'due_by_date',
        'closed_date'
    ];

    public function getRequestsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setRequestsAttribute($value)
    {
        $this->attributes['requests'] = json_encode($value);
    }

    public function getSolutionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSolutionsAttribute($value)
    {
        $this->attributes['solutions'] = json_encode($value);
    }

    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = json_encode($value);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'uuid',
        'rel_id',
        'level',
        'type',
        'site',
        'mode',
        'so',
        'so_status',
        'tac',
        'flag',
        'solutions',
        'technician_id',
        'technicians',
        'client_id',
        'invoice_id',
        'category_id',
        'company_id',
        'group_id',
        'client_email',
        'request_by',
        'followers',
        'sla_id',
        'priority_id',
        'status',
        'name',
        'root_cause',
        'content',
        'attachments',
        'hidden',

        'rma_doa',
        'eta',

        'part_device',
        'serial_number',
        'tracking_number',

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
        'closed_date',
        'email_time',
        'last_update',
    ];

    public function getSolutionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSolutionsAttribute($value)
    {
        $this->attributes['solutions'] = json_encode($value);
    }

    public function getTechniciansAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setTechniciansAttribute($value)
    {
        $this->attributes['technicians'] = json_encode($value);
    }

    public function getFollowersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setFollowersAttribute($value)
    {
        $this->attributes['followers'] = json_encode($value);
    }

    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = json_encode($value);
    }

    public function getRequest($id)
    {
        if (!Cache::has('request_' . $id)) {
            $request = $this->find($id);
            Cache::add('request_' . $id, $request, Data::$cacheTime);
        } else {
            $request = Cache::get('request_' . $id);
        }
        return $request;
    }
}

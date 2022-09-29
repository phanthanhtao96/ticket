<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'rel_mail_id',
        'rel_id',
        'replier_type',
        'replier_id',
        'replier_name',
        'name' => '',
        'content',
        'sent_mail',
        'send_mail_internal',
        'attachments'
    ];

    public function getAttachmentsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setAttachmentsAttribute($value)
    {
        $this->attributes['attachments'] = json_encode($value);
    }
}

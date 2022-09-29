<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;
    protected $table = 'mails';

    protected $fillable = [
        'type',
        'rel_id',
        'name',
        'content',
        'from',
        'to',
        'cc',
        'sent',
        'attachments'
    ];

    public function getToAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setToAttribute($value)
    {
        $this->attributes['to'] = json_encode($value);
    }

    public function getCcAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCcAttribute($value)
    {
        $this->attributes['cc'] = json_encode($value);
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

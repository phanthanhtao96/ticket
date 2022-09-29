<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EmailTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'name',
        'subject',
        'content'
    ];

    public function getEMailTemplate($type = '')
    {
        if (!Cache::has('email_template_' . $type)) {
            $emailTemplate = $this->where('type', trim($type))->first();
            Cache::add('email_template_' . $type, $emailTemplate, Data::$cacheTime);
        } else {
            $emailTemplate = Cache::get('email_template_' . $type);
        }
        return $emailTemplate;
    }
}

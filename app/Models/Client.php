<?php

namespace App\Models;

use App\Http\Controllers\MailController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'email',
        'name',
        'company_name',
        'phone',
        'postcode',
        'tax_code',
        'identification_number',
        'country',
        'city',
        'state',
        'address',
        'notes',
        'disable'
    ];

    public function createClientId($email, $name = '')
    {
        $result = $this->updateOrCreate([
            'email' => $email
        ], [
            'email' => $email,
            'name' => $name
        ]);
        return $result->id ?? 0;
    }

    public function getClientByMail($email)
    {
        $email = trim($email);
        if (!Cache::has('client_' . $email)) {
            $client = $this->where('email', $email)->first();
            Cache::add('client_' . $email, $client, Data::$cacheTime);
        } else {
            $client = Cache::get('client_' . $email);
        }
        return $client;
    }

    public function sendMailToCustomer($requestName, $message, $attachments, $requestId, $customerEmail){
        $content = Tool::addAttachmentForMail($attachments, $message);

        $customer = (new Client())->getClientByMail($customerEmail);
        (new MailController())->createMail(
            'ReplyTicketEmail',
            [
                'ticket_id' => $requestId,
                'ticket_name' => $requestName,
                'customer_name' => $customer->name,
                'reply_content' => $content
            ],
            env('OUTLOOK_MAIL_ADDRESS'),
            [$customerEmail],
            [],
            $attachments,
            $requestId
        );

        return 0;
    }
}

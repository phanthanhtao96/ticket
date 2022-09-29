<?php
/***SaoBacDauTelecom***/

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'service-desk@saobacdau.vn'), env('MAIL_FROM_NAME', 'Service Desk Notify'))
            ->to($this->data['to'])
            ->cc($this->data['cc'])
            ->subject($this->data['subject'])
            ->html($this->data['content']);
    }
}

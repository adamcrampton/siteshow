<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchNotification extends Mailable
{
    private $logData;
    private $emailFullName;
    private $emailSubject;
    private $emailFrom;

    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.fetch_notification')
            ->from($this->emailFrom[0], $this->emailFrom[1])
            ->subject($this->emailSubject)
            ->with($this->logData);
    }

    /**
     * Build the config.
     *
     * @param
     */
    public function buildConfig($logData)
    {
        // Since we have a lot of incoming data, we need to set it before calling the build method.
        $this->logData = $logData;
        $this->emailFullName = 'Siteshow Admin';
        $this->emailSubject = 'Fetch results';
        $this->emailFrom = ['admin@siteshow.test', 'Siteshow Fetch Logger'];
    }
}

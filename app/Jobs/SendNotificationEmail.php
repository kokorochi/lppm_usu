<?php

namespace App\Jobs;

use App\Mail\NotificationEmail;
use App\Propose;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue {
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $propose, $content, $recipients, $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipients, $email, Propose $propose)
    {
        $this->propose = $propose;
        $this->recipients = $recipients;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->recipients != '' && $this->recipients != null)
        {
            Mail::to($this->recipients)->send(new NotificationEmail($this->email));
        }
    }
}

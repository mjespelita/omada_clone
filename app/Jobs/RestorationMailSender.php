<?php

namespace App\Jobs;

use App\Mail\RestorationMailer;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class RestorationMailSender implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $name;
    public $ticket_number;
    public $siteId;
    public $time;
    public $reason;
    public $troubleshoot;
    public function __construct($name, $ticket_number, $siteId, $time, $reason, $troubleshoot)
    {
        $this->name = $name;
        $this->ticket_number = $ticket_number;
        $this->siteId = $siteId;
        $this->time = $time;
        $this->reason = $reason;
        $this->troubleshoot = $troubleshoot;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user['email'])->send(new RestorationMailer(
                $this->name,
                $this->ticket_number,
                $this->siteId,
                $this->time,
                $this->troubleshoot,
                $this->reason,
            ));
        }
    }
}

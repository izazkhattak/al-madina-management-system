<?php

namespace App\Events;

use App\Models\Installment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $installment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Installment $installment)
    {
        $this->installment = $installment;
    }
}

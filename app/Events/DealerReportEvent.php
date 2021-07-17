<?php

namespace App\Events;

use App\Models\DealerInstallment;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DealerReportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dealerInstallment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DealerInstallment $dealerInstallment)
    {
        $this->dealerInstallment = $dealerInstallment;
    }
}

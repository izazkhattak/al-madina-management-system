<?php

namespace App\Events;

use App\Models\ClientInstallment;
// use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientReportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clientInstallment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ClientInstallment $clientInstallment)
    {
        $this->clientInstallment = $clientInstallment;
    }
}

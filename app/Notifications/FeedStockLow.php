<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FeedStockLow extends Notification
{
    use Queueable;

    public function __construct(
        protected int $availableStock
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => sprintf('Feed stock is low: only %d sack(s) remain in the warehouse.', $this->availableStock),
            'available_stock' => $this->availableStock,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Offer;

class OfferSubmitted extends Notification
{
    use Queueable;

    protected $offer;

    /**
     * Create a new notification instance.
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'offer_id' => $this->offer->id,
            'car_id' => $this->offer->car_id,
            'car_title' => $this->offer->car->make . ' ' . $this->offer->car->model,
            'offer_price' => $this->offer->price,
            'sender_name' => $this->offer->name,
            'sender_email' => $this->offer->email,
            'sender_phone' => $this->offer->phone,
            'remark' => $this->offer->remark,
            'created_at' => $this->offer->created_at,
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Car;

class NewCarPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $car;

    /**
     * Create a new notification instance.
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Car Available - ' . $this->car->make . ' ' . $this->car->model)
            ->greeting('Hello!')
            ->line('A new car has been posted that might interest you!')
            ->line('**Car Details:**')
            ->line('Make: ' . $this->car->make)
            ->line('Model: ' . $this->car->model)
            ->line('Year: ' . $this->car->year)
            ->line('Price: $' . number_format($this->car->regular_price))
            ->line('Title: ' . $this->car->title)
            ->action('View Car Details', url('/cars/' . $this->car->id))
            ->line('Thank you for subscribing to our newsletter!')
            ->salutation('Best regards, Car Project Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'car_id' => $this->car->id,
            'car_make' => $this->car->make,
            'car_model' => $this->car->model,
        ];
    }
}

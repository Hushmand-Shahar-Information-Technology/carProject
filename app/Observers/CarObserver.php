<?php

namespace App\Observers;

use App\Models\Car;
use App\Models\User;
use App\Models\Email;
use App\Notifications\NewCarPostNotification;
use Illuminate\Support\Facades\Notification;

class CarObserver
{
    /**
     * Handle the Car "created" event.
     */
    public function created(Car $car): void
    {
        // Send notification to all subscribed users
        $this->sendNewCarNotifications($car);
    }

    /**
     * Handle the Car "updated" event.
     */
    public function updated(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "deleted" event.
     */
    public function deleted(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "restored" event.
     */
    public function restored(Car $car): void
    {
        //
    }

    /**
     * Handle the Car "force deleted" event.
     */
    public function forceDeleted(Car $car): void
    {
        //
    }

    /**
     * Send new car notifications to subscribed users
     */
    private function sendNewCarNotifications(Car $car): void
    {
        // Get all subscribed users
        $subscribedUsers = User::where('newsletter_subscribed', true)->get();

        // Get all subscribed emails from emails table
        $subscribedEmails = Email::all();

        // Create fake users for email-only subscribers
        $emailSubscribers = $subscribedEmails->map(function ($emailRecord) {
            $user = new User();
            $user->email = $emailRecord->email;
            $user->name = 'Subscriber';
            return $user;
        });

        // Combine both user types
        $allSubscribers = $subscribedUsers->concat($emailSubscribers);

        // Send notifications
        if ($allSubscribers->isNotEmpty()) {
            Notification::send($allSubscribers, new NewCarPostNotification($car));
        }
    }
}

<?php

namespace App\Notifications;

use App\Models\AuthActivityLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecurityAlertNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly AuthActivityLog $activityLog) {}

    public function via(object $notifiable): array
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail'];
        }

        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'auth_activity_log_id' => $this->activityLog->id,
            'event_type' => $this->activityLog->event_type,
            'risk_level' => $this->activityLog->risk_level,
            'email' => $this->activityLog->email,
            'ip_address' => $this->activityLog->ip_address,
            'occurred_at' => $this->activityLog->occurred_at?->toIso8601String(),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Security alert: '.$this->activityLog->event_type)
            ->line('A high-risk security activity was detected.')
            ->line('Event: '.$this->activityLog->event_type)
            ->line('Risk: '.$this->activityLog->risk_level)
            ->line('Email: '.($this->activityLog->email ?? '-'))
            ->line('IP: '.($this->activityLog->ip_address ?? '-'));
    }
}

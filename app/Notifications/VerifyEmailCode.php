<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailCode extends Notification
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Mã xác thực tài khoản - Phương Nam Shop')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Cảm ơn bạn đã đăng ký tài khoản tại Phương Nam Shop.')
            ->line('Mã xác thực email của bạn là:')
            ->line('🔐 ' . $this->code)
            ->line('Mã xác thực có hiệu lực trong 10 phút.')
            ->line('Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email.');
    }
}
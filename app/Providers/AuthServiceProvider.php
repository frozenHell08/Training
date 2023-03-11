<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Mail\VerifyRegister;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $subject = sprintf("Welcome to %s!", config('app.name'));

            return (new MailMessage)
                ->subject($subject)
                ->greeting('Good Day!')
                ->salutation(sprintf('Mr! %s', $notifiable))
                ->line('yes hello {{$notifiable}} sending from app registration.')
                ->action('nyoom', $url);

            // $user =

            // return (new VerifyRegister());
        });
    }
}

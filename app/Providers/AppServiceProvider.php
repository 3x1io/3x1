<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use JavaScript;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            Config::set('mail.mailers.smtp', [
                'transport' => 'smtp',
                'host' => setting('email.host'),
                'port' => setting('email.port'),
                'encryption' => setting('email.encryption'),
                'username' => setting('email.username'),
                'password' => setting('email.password'),
                'timeout' => null,
                'auth_mode' => null,
            ]);

            Config::set('mail.from', [
                'address' => setting('email.from'),
                'name' => setting('email.from.name'),
            ]);

            Config::set('broadcasting.connections.pusher', [
                'driver' => 'pusher',
                'key' => setting('pusher.key'),
                'secret' => setting('pusher.secret'),
                'app_id' => setting('pusher.app_id'),
                'options' => [
                    'cluster' => setting('pusher.cluster'),
                    'useTLS' => true,
                ],
            ]);

            Config::set('services.messagebird', [
                'access_key' => setting('messagebird.access_key'),
                'originator' => setting('messagebird.originator'),
                'recipients' => setting('messagebird.recipients'),
            ]);

            JavaScript::put([
                'pusherKey' => setting('pusher.key')
            ]);

            if(auth('admin')->user()){
                JavaScript::put([
                    'authId' => auth('admin')->user()->id
                ]);
            }
            else {
                JavaScript::put([
                    'authId' => null
                ]);
            }
        }
        catch (\Exception $exception){
            Log::alert($exception);
        }
    }
}

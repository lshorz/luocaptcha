<?php
namespace Lshorz\Luocaptcha;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class LCaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('lcaptcha.php'),
        ], 'lcaptcha');

        //扩展验证器
        $this->app['validator']->extend('lcaptcha', function($attribute, $value, $parameters, $validator){
            return Facades\LCaptcha::verify($value);
        }, config('lcaptcha.message.server_fail'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('LCaptcha', function () {
            return $this->app->make(LCaptcha::class);
        });
    }
}
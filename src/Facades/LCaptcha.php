<?php
namespace Lshorz\Luocaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class LCaptcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LCaptcha';
    }
}
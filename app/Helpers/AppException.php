<?php

namespace App\Helpers;

class AppException
{
    public static function log( \Exception $exception )
    {
       //Log exception here on sentry/db/file/email etc
    }
}


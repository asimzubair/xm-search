<?php

namespace App\Helpers;

class ThirdPartyApiCallLog
{
    public static function logNasdaqResponse($url, $method, $responseCode, $requestBody, $apiResponse, $title)
    {
       //Log responses here in db table or anywhere with API identification
    }

    public static function logYHFinanceResponse($url, $method, $responseCode, $requestBody, $apiResponse, $title)
    {
       //Log responses here in db table or anywhere with API identification
    }
}


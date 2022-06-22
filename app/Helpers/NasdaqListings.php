<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class NasdaqListings
{
    const ENDPOINT = "https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json";

    public static function getCompaniesDropdown()
    {
        try
        {
            $cacheKey = 'get_companies_dropdown';
            $dropdown = Cache::remember($cacheKey, env('CACHE_REMEMBER_SECONDS'), function ()  {
                $companiesList = self::__getCompanies();
                $dropdown =  self::__makeDropdownData($companiesList);
            });

            return $dropdown;
        }
        catch (\Exception $e)
        {
            AppException::log($e);
            return [];
        }
    }

    private static function __getCompanies()
    {
        $apiEndpoint = self::ENDPOINT;
        $apiResponse =  self::__sendRequest( $apiEndpoint, 'get nasdaq companies list' );
        return $apiResponse['content'] ?? [];
    }

    private static function __makeDropdownData( $companiesList )
    {
        $companies = [];
        foreach( $companiesList as $key => $company )
        {
            $companies[ $company['Symbol'] ] = $company['Company Name'];
        }
        return $companies;
    }

    private static function __sendRequest( $url, $title='', $method = 'GET', $requestBody = [], $format = 'form_params' )
    {
        $apiResponse = Helper::apiRequest( $method, $url, [], $requestBody, [], $format, true);
        $responseCode = $apiResponse['code'] ?? 0;
        
        ThirdPartyApiCallLog::logNasdaqResponse($url, $method, $responseCode, $requestBody, $apiResponse, $title);
        
        return $apiResponse;
    }
}
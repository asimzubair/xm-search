<?php

namespace App\Helpers;

class YHFinance
{
    const ENDPOINT = "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data?symbol=";
    const APIKEY = "575cdeb169msh912ecedf5e0c44ap1a766fjsn7ce7f0d811c7"; #should be in ENV

    public static function getHistoricalData( $companySymbol )
    {
        try
        {
            $apiEndpoint = self::ENDPOINT.$companySymbol;
            $apiResponse =  self::__sendRequest( $apiEndpoint, "get yh-finance historical data for company $companySymbol" );
            return $apiResponse['content'] ?? [];
        }
        catch (\Exception $e)
        {
            AppException::log($e);
            return [];
        }
    }

    private static function __sendRequest( $url, $title='', $method = 'GET', $requestBody = [], $format = 'json' )
    {
        $headers = [
            "X-RapidAPI-Host" => "yh-finance.p.rapidapi.com",
            "X-RapidAPI-Key" => self::APIKEY
        ];

        $apiResponse = Helper::apiRequest( $method, $url, [], $requestBody, $headers, $format, true);
        $responseCode = $apiResponse['code'] ?? 0;
        
        ThirdPartyApiCallLog::logNasdaqResponse($url, $method, $responseCode, $requestBody, $apiResponse, $title);
        
        return $apiResponse;
    }
}
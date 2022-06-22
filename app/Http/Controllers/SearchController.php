<?php

namespace App\Http\Controllers;

use App\Helpers\YHFinance;
use App\Helpers\AppException;
use App\Mail\SearchResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class SearchController extends BaseController
{
    public function search(Request $request)
    {
        try
        {
            $requestData = $request->all();
            $validator = Validator::make( $requestData, self::__getValidationRules() );
            
		    if ($validator->fails())
	        {
	            return redirect()->back()->withInput($request->input())->withErrors($validator->errors());
	        }
	        else
	        {
                $historicalData = YHFinance::getHistoricalData( $requestData['company_symbol'] );
                $dateRangeData = self::__filterDataByDateRange( $historicalData, $requestData );
                Mail::to($requestData['email'])->send(new SearchResults($requestData));
                return view('search', compact('dateRangeData', 'requestData'));
            }
        }
        catch (\Exception $e)
        {
            AppException::log($e);
            return redirect()->back()->withErrors($e);
        }
    }

    private static function __getValidationRules()
    {
        return [
            'company_symbol'   => 'required',
            'start_date'   => 'required|date_format:Y-m-d|before_or_equal:today|before_or_equal:end_date',
            'end_date'   => 'required|date_format:Y-m-d|before_or_equal:today|after_or_equal:start_date',
            'email'   => 'required|email',
        ];
    }

    private static function __filterDataByDateRange( $historicalData, $requestData )
    {
        $filteredHistoricalData = [];
        if(isset($historicalData['prices']))
        {
            foreach( $historicalData['prices'] as $price )
            {
                $priceDate = date('Y-m-d', $price['date']);
                if( $priceDate >= $requestData['start_date'] &&  $priceDate <= $requestData['end_date'] )
                {
                    $price['date'] = $priceDate;
                    $filteredHistoricalData[] = $price;
                }
            }
        }

        return $filteredHistoricalData;
    }
}

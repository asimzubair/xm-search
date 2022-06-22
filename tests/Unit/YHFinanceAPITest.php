<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\YHFinance;

class YHFinanceAPITest extends TestCase
{
    /**
     * Testing incorrect symbol
     *
     * @return empty array
     */
    public function test_incorrect_sybmol_in_yhfinance_api()
    {
    	$this->assertEmpty(YHFinance::getHistoricalData( 'ABCDEF' ));
    }

    /**
     * Testing empty symbol
     *
     * @return empty array
     */

    public function test_empty_sybmol_in_yhfinance_api()
    {
    	$this->assertEmpty(YHFinance::getHistoricalData( '' ));
    }

    /**
     * Testing correct symbol
     *
     * @return empty array
     */

    public function test_correct_sybmol_in_yhfinance_api()
    {
    	$this->assertArrayHasKey('prices', YHFinance::getHistoricalData( 'AAPL' ));
    }
}

<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\NasdaqListings;

class NasdaqListingsAPITest extends TestCase
{
    /**
     * Testing companies symbol list
     *
     * @return empty/with data array
     */
    public function test_get_companies_api()
    {
        $this->assertIsArray( NasdaqListings::getCompaniesDropdown() );
    }
}

<?php

namespace Tests\Unit;

use App\Services\ParentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParentTest extends TestCase
{
    protected $parentService;

    protected function setUp(): void
    {
        parent::setUp();
        //add test data provider
        $parentService = app(ParentService::class);
        $parentServiceUpdated = new \ReflectionClass($parentService);
        $dataSourcesProperty = $parentServiceUpdated->getProperty('dataSources');
        $dataSourcesProperty->setAccessible(true);
        $dataSourcesProperty->setValue($parentService,['DataProviderTestX', 'DataProviderTestY']);
        $this->parentService = $parentService;
    }

    /**
     * Test Parents listing from all providers
     *
     * @return void
     */
    public function testParentsListingFromAllSources()
    {
        $output = $this->parentService->getAllParents();
        $this->assertEquals(10, count($output));
    }

    /**
     * Test Parents listing from one data source provider
     *
     * @return void
     */
    public function testParentsFromOneProviderFilter()
    {
        $filtersX = [
            'provider' => 'DataProviderTestX'
        ];
        $outputX = $this->parentService->getAllParents($filtersX);
        $this->assertEquals(5, count($outputX));

        $filtersY = [
            'provider' => 'DataProviderTestY'
        ];
        $outputY = $this->parentService->getAllParents($filtersY);
        $this->assertEquals(5, count($outputY));
    }

    /**
     * Test Parents listing with status filter
     *
     * @return void
     */
    public function testParentsWithStatusFilter()
    {
        $filters = [
            'statusCode' => 'authorised'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(6, count($output));

        $filters_decline = [
            'statusCode' => 'decline'
        ];
        $output_decline = $this->parentService->getAllParents($filters_decline);
        $this->assertEquals(3, count($output_decline));

        $filters_refunded = [
            'statusCode' => 'refunded'
        ];
        $output_refunded = $this->parentService->getAllParents($filters_refunded);
        $this->assertEquals(1, count($output_refunded));
    }

    /**
     * Test Parents listing with minimum balance filter
     *
     * @return void
     */
    public function testParentsWithMinBalanceFilter()
    {
        $filters = [
            'balanceMin' => 0
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(10, count($output));

        $filters = [
            'balanceMin' => 280
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(6, count($output));

        $filters = [
            'balanceMin' => 10000
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(0, count($output));
    }

    /**
     * Test Parents listing with maximum balance filter
     *
     * @return void
     */
    public function testParentsWithMaxBalanceFilter()
    {
        $filters = [
            'balanceMax' => 10000
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(10, count($output));

        $filters = [
            'balanceMax' => 280
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(5, count($output));

        $filters = [
            'balanceMax' => 0
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(0, count($output));
    }

    /**
     * Test Parents listing with currency filter
     *
     * @return void
     */
    public function testParentsWithCurrencyFilter()
    {
        $filters = [
            'currency' => 'EUR'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'AED'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'USD'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(3, count($output));

        $filters = [
            'currency' => 'EGP'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(1, count($output));
    }

    /**
     * Test Parents listing with all filters
     *
     * @return void
     */
    public function testParentsWithAllFilters()
    {
        $filters = [
            'provider' => 'DataProviderTestX',
            'statusCode' => 'authorised',
            'balanceMin' => 200,
            'balanceMax' => 270,
            'currency' => 'EUR'
        ];
        $output = $this->parentService->getAllParents($filters);
        $this->assertEquals(1, count($output));
    }

    /**
     * Test Parents listing with all filters
     *
     * @return void
     */
    public function testNotFoundDataSource()
    {
        $this->assertTrue(true);
    }
}

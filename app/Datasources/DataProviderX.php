<?php
namespace App\Datasources;

/**
 * Class DataProviderX
 * @package App\Datasources
 */
class DataProviderX extends AbstractDataProvider
{
    /**
     * datasource json file
     * @var string
     */
    protected $fileName = "DataProviderX.json";

    /**
     * to store filters based on request
     * @var array
     */
    protected $filters = [];

    /**
     * map status codes
     * @var array
     */
    protected $statusCodes = [
        'authorised' => 1,
        'decline' => 2,
        'refunded' => 3
    ];

    /**
     * Filter by status code name
     * @param string $status
     */
    public function filterByStatus(string $status)
    {
        $this->filters[] = [
            'name' => 'statusCode',
            'value' => $this->statusCodes[$status],
            'operator' => '='
        ];
    }

    /**
     * Filter by min balance
     * @param int $from
     */
    public function filterByBalanceMin(int $from)
    {
        $this->filters[] = [
            'name' => 'parentAmount',
            'value' => $from,
            'operator' => '>='
        ];
    }

    /**
     * Filter by max balance
     * @param int $to
     */
    public function filterByBalanceMax(int $to)
    {
        $this->filters[] = [
            'name' => 'parentAmount',
            'value' => $to,
            'operator' => '<='
        ];
    }

    /**
     * Filter by currency code string
     * @param string $currency
     */
    public function filterByCurrency(string $currency)
    {
        $this->filters[] = [
            'name' => 'Currency',
            'value' => $currency,
            'operator' => '='
        ];
    }
}

<?php
namespace App\Datasources;

/**
 * Class DataProviderY
 * @package App\Datasources
 */
class DataProviderY extends AbstractDataProvider
{
    /**
     * datasource json file
     * @var string
     */
    protected $fileName = "DataProviderY.json";

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
        'authorised' => 100,
        'decline' => 200,
        'refunded' => 300
    ];

    /**
     * Filter by status code name
     * @param string $status
     */
    public function filterByStatus(string $status)
    {
        $this->filters[] = [
            'name' => 'status',
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
            'name' => 'balance',
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
            'name' => 'balance',
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
            'name' => 'currency',
            'value' => $currency,
            'operator' => '='
        ];
    }
}

<?php



namespace Payolution\Tests\Mocks\Request\Invoice;

use Payolution\Tests\Mocks\Request\PreCheckDataAbstract;
use Payolution\Tests\Mocks\Request\PreCheckDataContract;
use Tests\Payolution\Helpers\Config;

/**
 * Class PreCheckData
 */
class PreCheckData extends PreCheckDataAbstract implements PreCheckDataContract
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
            'mode' => 'CONNECTOR_TEST',
            'transactionId' => 42,
        ] + Config::getPaymentConfig('Invoice', 'PreCheck');
    }
}

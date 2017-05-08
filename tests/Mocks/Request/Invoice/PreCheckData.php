<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\PreCheckDataAbstract;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;

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

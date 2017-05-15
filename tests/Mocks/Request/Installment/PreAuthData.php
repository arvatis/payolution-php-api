<?php

namespace ArvPayolutionApi\Mocks\Request\Installment;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Request\RequestTypes;

class PreAuthData extends \ArvPayolutionApi\Mocks\Request\Installment\RequestData
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 42,
            ] + Config::getPaymentConfig('Installment', RequestTypes::PRE_AUTH);
    }
}

<?php

namespace   ArvPayolutionApi\Mocks\Request\Installment;
use ArvPayolutionApi\Helpers\Config;

class CalculationData extends \ArvPayolutionApi\Mocks\Request\Installment\PreCheckData
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'TEST',
                'transactionId' => 42,
            ] + Config::getPaymentConfig('Installment', 'Calculation');
    }
}
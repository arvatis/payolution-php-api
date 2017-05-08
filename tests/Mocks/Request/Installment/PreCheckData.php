<?php

namespace ArvPayolutionApi\Mocks\Request\Installment;

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
            ] + Config::getPaymentConfig('Installment', 'PreCheck');
    }

    /**
     * @return array
     */
    public function getAccountData()
    {
        return [
            'holder' => 'Max Mustermann',
            'country' => 'AT',
            'bic' => 'GIBAATWW',
            'iban' => 'AT622011198765432123',
        ];
    }

    /**
     * @return array
     */
    public function getInstallmentData()
    {
        return [
            'calculationId' => 'Tx-....', // UniqueID
            'amount' => '359.98',
            'durationInMonth' => 6,
        ];
    }
}

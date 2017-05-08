<?php

namespace ArvPayolutionApi\Mocks\Request\Elv;

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
            ] + Config::getPaymentConfig('Elv', 'PreCheck');
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
    public function getCustomer()
    {
        return [
            'customerId' => 'customerid123456',
            'gender' => 'M',
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'email' => 'whitelist-test@payolution.com',
            'customerIp' => '000.000.000.000',
            'dob' => '1970-01-30',
            'language' => 'de',
            'registrationDate' => '2017-01-03',
            'group' => 'TOP',
            'phone' => '',
        ];
    }
}

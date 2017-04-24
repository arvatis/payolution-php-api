<?php



namespace Payolution\Tests\Mocks\Request\Elv;

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

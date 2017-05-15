<?php

namespace ArvPayolutionApi\Mocks\Request\Elv;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\RequestDataAbstract;
use ArvPayolutionApi\Mocks\Request\RequestDataContract;

/**
 * Class PreCheckData
 */
class PreCheckData extends RequestDataAbstract implements RequestDataContract
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
           'context' => $this->getApiContext(),
           'customer' => $this->getCustomer(),
           'shippingAddress' => $this->getShippingAddress(),
           'billingAddress' => $this->getCustomerAddress(),
           'cart' => $this->getCart(),
           'cartItems' => $this->getCartItems(),
           'systemInfo' => $this->getSytemInfo(),
           'account' => $this->getAccountData(),
       ];
    }
}

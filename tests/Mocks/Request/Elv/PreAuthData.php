<?php

namespace ArvPayolutionApi\Mocks\Request\Elv;

use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\RequestDataAbstract;
use ArvPayolutionApi\Mocks\Request\RequestDataContract;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class PreAuthData
 */
class PreAuthData extends RequestDataAbstract implements RequestDataContract
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 42,
            ] + Config::getPaymentConfig('Elv', RequestTypes::PRE_AUTH);
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
    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'cartItems' => $this->getCartItems(),
            'systemInfo' => $this->getSytemInfo(),
            'shippingAddress' => $this->getCustomerAddress(),
            'billingAddress' => $this->getCustomerAddress(),
            'cart' => $this->getCart(),
            'customer' => $this->getCustomer(),
            'account' => $this->getAccountData(),
            'sessionId' => 'payolution_de_827ccb0eea8a706c4c34a16891f84e7b',
        ];
    }
}

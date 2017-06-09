<?php

namespace ArvPayolutionApi\Mocks\Request\Installment;

use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Request\RequestTypes;

class PreAuthData extends PreCheckData
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

    /**
     * @return array
     */
    public function getCustomerAddress()
    {
        return [
                'countryCode' => 'DE',
                'postCode' => '41460',
            ] + parent::getCustomerAddress();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'customer' => $this->getCustomer(),
            'shippingAddress' => $this->getCustomerAddress(),
            'billingAddress' => $this->getCustomerAddress(),
            'cart' => $this->getCart(),
            'cartItems' => $this->getCartItems(),
            'systemInfo' => $this->getSytemInfo(),
            'account' => $this->getAccountData(),
            'installment' => $this->getInstallmentData(),
        ];
    }
}

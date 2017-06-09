<?php

namespace ArvPayolutionApi\Mocks\Request\Installment;

use ArvPayolutionApi\Mocks\Config;

class CalculationData extends PreCheckData
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

    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'customer' => '',
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

<?php

namespace   ArvPayolutionApi\Mocks\Request\Installment;

use ArvPayolutionApi\Helpers\Config;

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

    public function jsonSerialize()
    {
        return [
         'context' => $this->getApiContext(),
         'customer' => '',
         'shippingAddress' => $this->getShippingAddress(),
         'billingAddress' => $this->getCustomerAddress(),
         'cart' => $this->getCart(),
         'cartItems' => $this->getCartItems(),
         'systemInfo' => $this->getSytemInfo(),
         'account' => $this->getAccountData(),
         'installment' => $this->getInstallmentData(),
     ];
    }
}

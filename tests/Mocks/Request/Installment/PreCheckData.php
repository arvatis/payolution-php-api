<?php

namespace ArvPayolutionApi\Mocks\Request\Installment;

use ArvPayolutionApi\Mocks\Config;
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

    /**
     * @return array
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
           'installment' => $this->getInstallmentData(),
       ];
    }
}

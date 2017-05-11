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
           'installment' => $this->getInstallmentData(),
       ];
    }
}

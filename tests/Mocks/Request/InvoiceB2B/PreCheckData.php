<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

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
            ] + Config::getPaymentConfig('InvoiceB2B', 'PreCheck');
    }

    /**
     * @return array
     */
    public function getCustomerAddress()
    {
        $data = parent::getCustomerAddress();
        $data['company'] = 'Payolution Company';

        return $data;
    }

    /**
     * @return array
     */
    public function getCompany()
    {
        return [
            'name' => 'Payolution Company',
            'type' => 'COMPANY',
            'registration_no' => '',
            'vat_id' => 'ATU4514545',
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
            'company' => $this->getCompany(),
        ];
    }
}

<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

use ArvPayolutionApi\Helpers\Config;
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
            ] + Config::getPaymentConfig('InvoiceB2B', RequestTypes::PRE_AUTH);
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'cartItems' => $this->getCartItems(),
            'systemInfo' => $this->getSytemInfo(),
            'shippingAddress' => $this->getShippingAddress(),
            'billingAddress' => $this->getCustomerAddress(),
            'cart' => $this->getCart(),
            'customer' => $this->getCustomer(),
            'company' => $this->getCompany(),
        ];
    }
}

<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\PreCheckDataAbstract;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class PreCheckData
 */
class PreAuthData extends PreCheckDataAbstract implements PreCheckDataContract
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

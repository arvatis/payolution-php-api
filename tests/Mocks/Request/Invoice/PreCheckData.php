<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

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
        ] + Config::getPaymentConfig('Invoice', 'PreCheck');
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
            'sessionId' => 'payolution_de_827ccb0eea8a706c4c34a16891f84e7b',
        ];
    }
}

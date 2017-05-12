<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\PreCheckDataAbstract;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class RefundData
 */
class RefundData extends PreCheckDataAbstract implements PreCheckDataContract
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 4564,
            ] + Config::getPaymentConfig('Invoice', RequestTypes::REFUND);
    }

    /**
     * @return array
     */
    public function getInvoice()
    {
        return [
            'invoiceId' => '125',
        ];
    }

    /**
     * @return array
     */
    public function getSytemInfo()
    {
        $data = parent::getSytemInfo();
        $data['type'] = 'CronJob';

        return $data;
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
            'cart' => $this->getCart(),
            'customer' => '',
            'invoice' => $this->getInvoice(),
        ];
    }
}

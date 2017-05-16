<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\RequestDataAbstract;
use ArvPayolutionApi\Mocks\Request\RequestDataContract;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class ReversalData
 */
class ReversalData extends RequestDataAbstract implements RequestDataContract
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 125,
            ] + Config::getPaymentConfig('InvoiceB2B', RequestTypes::REVERSAL);
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
            'systemInfo' => $this->getSytemInfo(),
            'customer' => $this->getCustomer(),
            'invoice' => $this->getInvoice(),
        ];
    }
}

<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\PreCheckDataAbstract;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class ReversalData
 */
class ReversalData extends PreCheckDataAbstract implements PreCheckDataContract
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 125,
            ] + Config::getPaymentConfig('Invoice', RequestTypes::REVERSAL);
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

<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

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
}

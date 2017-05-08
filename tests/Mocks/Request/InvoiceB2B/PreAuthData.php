<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData as PreCheckDataInvoice;

/**
 * Class PreCheckData
 */
class PreAuthData extends extends PreCheckDataAbstract implements PreCheckDataContract
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
}

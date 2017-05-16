<?php

namespace ArvPayolutionApi\Mocks\Request\InvoiceB2B;

use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as CaptureDataInvoice;

/**
 * Class PreCheckData
 */
class CaptureData extends CaptureDataInvoice
{
    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => '125',
                'referenceId' => '40288b162da3e294012db761fd734134',
            ] + Config::getPaymentConfig('InvoiceB2B', 'Capture');
    }
}

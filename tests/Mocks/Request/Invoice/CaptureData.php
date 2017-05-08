<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\PreCheckDataAbstract;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;

/**
 * Class PreCheckData
 */
class CaptureData extends PreCheckDataAbstract implements PreCheckDataContract
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
            ] + Config::getPaymentConfig('Invoice', 'Capture');
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
    public function getOrder()
    {
        return [
            'orderId' => '42',
        ];
    }

    /**
     * @return array
     */
    public function getTracking()
    {
        return [
            'trackingId' => '4564531894784',
            'returnTrackingId' => '18615486',
            'shippingCompany' => 'DHL',
        ];
    }

    /**
     * @return array
     */
    public function getSytemInfo()
    {
        return [
            'vendor' => 'CustomSystemName_ProgrammingLanguage_XML',
            'version' => 'CustomSystemVersion',
            'type' => 'CronJob',
            'url' => 'www.shop.example.com',
            'module' => 'PaymentModuleName',
            'module_version' => 'PaymentModuleVersion',
        ];
    }
}

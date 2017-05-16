<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\RequestDataAbstract;
use ArvPayolutionApi\Mocks\Request\RequestDataContract;

/**
 * Class PreCheckData
 */
class CaptureData extends RequestDataAbstract implements RequestDataContract
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'cartItems' => $this->getCartItems(),
            'systemInfo' => $this->getSytemInfo(),
            'invoice' => $this->getInvoice(),
            'order' => $this->getOrder(),
            'tracking' => $this->getTracking(),
            'cart' => $this->getCart(),
            'customer' => $this->getCustomer(),
        ];
    }
}

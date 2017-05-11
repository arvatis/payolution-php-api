<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as InvoiceCaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData as InvoicePreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData as InvoicePreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;
use GuzzleHttp\Client;

/**
 * Class InvoiceRequestTest
 *
 * @group Invoice
 */
class InvoiceRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var  RequestXmlMockFactory
     */
    protected $xmlMock;

    /**
     * @var XmlSerializer
     */
    protected $xmlSerializer;

    /**
     * @var XmlApi
     */
    private $xmlApi;

    /** @var PreCheckDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->data = new PreCheckDataGenerated();
        $this->xmlSerializer = XmlSerializerFactory::create();
        $this->xmlMock = new RequestXmlMockFactory();
        $this->xmlApi = new XmlApi(new ApiClient(new Client()));
    }

    public function testInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoicePreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($paymentBrand, $requestType)->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
        );
    }

    public function testInvoicePreAuthSameAsMock()
    {
        $this->data = new InvoicePreAuthData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_AUTH;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INVOICE,
                $requestType
            )->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId)->saveXml()
        );
    }

    public function testInvoiceCaptureSameAsMock()
    {
        $this->data = new InvoiceCaptureData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::CAPTURE;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INVOICE,
                $requestType
            )->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId)->saveXml()
        );
    }
}

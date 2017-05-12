<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as InvoiceCaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData as InvoicePreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData as InvoicePreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\Invoice\RefundData;
use ArvPayolutionApi\Mocks\Request\Invoice\ReversalData;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;
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
    private $paymentMethod;

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
        $this->paymentMethod = $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INVOICE;
    }

    public function testInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoicePreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($this->paymentMethod, $requestType)->saveXml(),
            PreCheckRequestFactory::create($requestType, $this->paymentMethod, $data)->saveXml()
        );
    }

    public function testInvoicePreAuthSameAsMock()
    {
        $this->data = new InvoicePreAuthData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_AUTH;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            PreAuthRequestFactory::create($requestType, $this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }

    public function testInvoiceCaptureSameAsMock()
    {
        $this->data = new InvoiceCaptureData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::CAPTURE;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            CaptureRequestFactory::create($requestType, $this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }

    public function testRefundSameAsMock()
    {
        $this->data = new RefundData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::REFUND;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            RefundRequestFactory::create($requestType, $this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }

    public function testReversalSameAsMock()
    {
        $this->data = new ReversalData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::REVERSAL;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            ReversalRequestFactory::create($requestType, $this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }
}

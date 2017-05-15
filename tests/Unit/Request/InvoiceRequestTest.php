<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as InvoiceCaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData as InvoicePreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\ReAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\RefundData;
use ArvPayolutionApi\Mocks\Request\Invoice\RequestDataGenerated;
use ArvPayolutionApi\Mocks\Request\Invoice\ReversalData;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\ReAuthRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;

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
     * @var string
     */
    private $paymentMethod;

    /** @var RequestDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->xmlMock = new RequestXmlMockFactory();
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INVOICE;
    }

    public function testInvoicePreCheckSameAsMock()
    {
        $data = new PreCheckData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($this->paymentMethod, $requestType)->saveXml(),
            PreCheckRequestFactory::create($requestType, $this->paymentMethod, $data)->saveXml()
        );
    }

    public function testInvoicePreAuthSameAsMock()
    {
        $data = new InvoicePreAuthData();
        $data = $data->jsonSerialize();

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
        $data = new InvoiceCaptureData();
        $data = $data->jsonSerialize();

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
        $data = new RefundData();
        $data = $data->jsonSerialize();

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
        $data = new ReversalData();
        $data = $data->jsonSerialize();

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

    public function testReAuthSameAsMock()
    {
        $data = new ReAuthData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::RE_AUTH;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            ReAuthRequestFactory::create($requestType, $this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }
}

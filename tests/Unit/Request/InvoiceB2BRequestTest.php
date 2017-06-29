<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\InvoiceB2B\CaptureData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckData as InvoiceB2BPreCheckData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\ReAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\RefundData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\ReversalData;
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
 * @group InvoiceB2BRequestTest
 */
class InvoiceB2BRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var  RequestXmlMockFactory
     */
    protected $xmlMock;

    /**
     * @var string
     */
    private $paymentMethod;

    protected function setUp()
    {
        $this->xmlMock = new RequestXmlMockFactory();
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;
    }

    public function testB2BInvoicePreCheckSameAsMock()
    {
        $data = new InvoiceB2BPreCheckData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($this->paymentMethod, $requestType)->saveXml(),
            PreCheckRequestFactory::create($this->paymentMethod, $data)->saveXml()
        );
    }

    public function testInvoiceB2BPreAuthSameAsMock()
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_AUTH;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $mockXml = RequestXmlMockFactory::getRequestXml(
            $this->paymentMethod,
            $requestType
        )->saveXml();
        $this->assertSame(
            $mockXml,
            PreAuthRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }

    public function testInvoiceCaptureSameAsMock()
    {
        $data = new CaptureData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::CAPTURE;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                $this->paymentMethod,
                $requestType
            )->saveXml(),
            CaptureRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
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
            RefundRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
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
            ReversalRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
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
            ReAuthRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }
}

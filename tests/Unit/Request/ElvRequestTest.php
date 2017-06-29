<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Elv\CaptureData;
use ArvPayolutionApi\Mocks\Request\Elv\PreAuthData;
use ArvPayolutionApi\Mocks\Request\Elv\PreCheckData;
use ArvPayolutionApi\Mocks\Request\Elv\ReAuthData;
use ArvPayolutionApi\Mocks\Request\Elv\RefundData;
use ArvPayolutionApi\Mocks\Request\Elv\ReversalData;
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
 * Class ElvRequestTest
 *
 * @group RequestTest
 */
class ElvRequestTest extends \PHPUnit_Framework_TestCase
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
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_ELV;
    }

    public function testPreCheckSameAsMock()
    {
        $data = new PreCheckData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($this->paymentMethod, $requestType)->saveXml(),
            PreCheckRequestFactory::create($this->paymentMethod, $data)->saveXml()
        );
    }

    public function testPreAuthSameAsMock()
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
        self::markTestSkipped('No test data provided by payolution.');
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
        self::markTestSkipped('No test data provided by payolution.');
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
        self::markTestSkipped('No test data provided by payolution.');
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
        self::markTestSkipped('No test data provided by payolution.');
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

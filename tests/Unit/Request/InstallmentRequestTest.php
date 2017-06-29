<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Installment\CalculationData;
use ArvPayolutionApi\Mocks\Request\Installment\CaptureData;
use ArvPayolutionApi\Mocks\Request\Installment\PreAuthData;
use ArvPayolutionApi\Mocks\Request\Installment\PreCheckData;
use ArvPayolutionApi\Mocks\Request\Installment\ReAuthData;
use ArvPayolutionApi\Mocks\Request\Installment\RefundData;
use ArvPayolutionApi\Mocks\Request\Installment\ReversalData;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\CalculationRequestFactory;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\ReAuthRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;

/**
 * Class InstallmentRequestTest
 *
 * @group InstallmentRequestTest
 */
class InstallmentRequestTest extends \PHPUnit_Framework_TestCase
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
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INS;
    }

    public function testPreCheckSameAsMock()
    {
        $data = new PreCheckData();
        $data = $data->jsonSerialize();

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($this->paymentMethod, RequestTypes::PRE_CHECK)->saveXml(),
            PreCheckRequestFactory::create($this->paymentMethod, $data)->saveXml()
        );
    }

    public function testPreAuthSameAsMock()
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();

        $previousRequestId = '53488b162da3e294012db761fd734288';

        $mockXml = RequestXmlMockFactory::getRequestXml(
            $this->paymentMethod,
            RequestTypes::PRE_AUTH
        )->saveXml();
        $this->assertSame(
            $mockXml,
            PreAuthRequestFactory::create($this->paymentMethod, $data, $previousRequestId)->saveXml()
        );
    }

    public function testCaptureSameAsMock()
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

    public function testCalculationSameAsMock()
    {
        $data = new CalculationData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::CALCULATION;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INS,
                $requestType
            )->saveXml(),
            CalculationRequestFactory::create($this->paymentMethod, $data)->saveXml()
        );
    }
}

<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Elv\PreCheckData as ElvPreCheckData;
use ArvPayolutionApi\Mocks\Request\Installment\PreCheckData as InstallmentPreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData as InvoiceCaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData as InvoicePreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData as InvoicePreCheckData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckData as InvoiceB2BPreCheckData;
use ArvPayolutionApi\Mocks\Request\PreCheckDataContract;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class RequestFactoryTest
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var PreCheckDataContract $data */
    private $data;

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

    public function testElvPreCheckSameAsMock()
    {
        $this->data = new ElvPreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_ELV;

        self::assertSame(
            RequestXmlMockFactory::getRequestXml(RequestPaymentTypes::PAYOLUTION_ELV, $requestType)->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
        );
    }

    public function testInstallmentPreCheckSameAsMock()
    {
        $this->data = new InstallmentPreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INS,
                $requestType
            )->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
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

    public function testB2BInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoiceB2BPreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml($paymentBrand, $requestType)->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
        );
    }

    public function testInvoiceB2BPreAuthSameAsMock()
    {
        $this->data = new PreAuthData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_AUTH;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $mockXml = RequestXmlMockFactory::getRequestXml(
            $paymentBrand,
            $requestType
        )->saveXml();
        $this->assertSame(
            $mockXml,
            RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId)->saveXml()
        );
    }
}

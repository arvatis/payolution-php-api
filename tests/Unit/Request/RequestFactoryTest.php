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
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;

/**
 * Class RequestFactoryTest
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlSerializer
     */
    protected $xmlSerializer;
    /** @var PreCheckDataContract $data */
    private $data;

    public function setUp()
    {
        $this->xmlSerializer = XmlSerializerFactory::create();
    }

    public function testInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoicePreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
        ];

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml($paymentBrand, $requestType)->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testElvPreCheckSameAsMock()
    {
        $this->data = new ElvPreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'account' => $this->data->getAccountData(),
        ];

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_ELV;

        self::assertSame(
            PreCheckXmlMockFactory::getRequestXml(RequestPaymentTypes::PAYOLUTION_ELV, $requestType)->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testInstallmentPreCheckSameAsMock()
    {
        $this->data = new InstallmentPreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'account' => $this->data->getAccountData(),
            'installment' => $this->data->getInstallmentData(),
        ];

        $requestType = RequestTypes::PRE_CHECK; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INS,
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testInvoiceCaptureSameAsMock()
    {
        $this->data = new InvoiceCaptureData();
        $data = [
            'context' => $this->data->getApiContext(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'invoice' => $this->data->getInvoice(),
            'order' => $this->data->getOrder(),
            'tracking' => $this->data->getTracking(),
            'cart' => $this->data->getCart(),
            'customer' => $this->data->getCustomer(),
        ];

        $requestType = RequestTypes::CAPTURE; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '40288b162da3e294012db761fd734134';

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INVOICE,
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId),
                ],
                true
            )
        );
    }

    public function testInvoicePreAuthSameAsMock()
    {
        $this->data = new InvoicePreAuthData();
        $data = [
            'context' => $this->data->getApiContext(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'customer' => $this->data->getCustomer(),
        ];

        $requestType = RequestTypes::PRE_AUTH; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INVOICE,
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId),
                ],
                true
            )
        );
    }

    public function testB2BInvoicePreCheckSameAsMock()
    {
        $this->data = new InvoiceB2BPreCheckData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'company' => $this->data->getCompany(),
        ];

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml($paymentBrand, $requestType)->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    public function testInvoiceB2BPreAuthSameAsMock()
    {
        $this->data = new PreAuthData();
        $data = [
            'context' => $this->data->getApiContext(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'customer' => $this->data->getCustomer(),
            'company' => $this->data->getCompany(),
        ];

        $requestType = RequestTypes::PRE_AUTH;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;
        $previousRequestId = '53488b162da3e294012db761fd734288';

        $mockXml = PreCheckXmlMockFactory::getRequestXml(
            $paymentBrand,
            $requestType
        )->saveXml();
        $this->assertSame(
            $mockXml,
            $this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $previousRequestId),
                ],
                true
            )
        );
    }
}

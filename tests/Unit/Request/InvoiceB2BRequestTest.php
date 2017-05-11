<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckData as InvoiceB2BPreCheckData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckDataGenerated;
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
 * @group InvoiceB2BRequestTest
 */
class InvoiceB2BRequestTest extends \PHPUnit_Framework_TestCase
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

<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Elv\PreCheckData as ElvPreCheckData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
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
class ElvRequestTest extends \PHPUnit_Framework_TestCase
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

    public function testElvPreCheckSameAsMock()
    {
        $this->data = new ElvPreCheckData();
        $data = $this->data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_ELV;

        self::assertSame(
            RequestXmlMockFactory::getRequestXml(RequestPaymentTypes::PAYOLUTION_ELV, $requestType)->saveXml(),
            PreCheckRequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
        );
    }
}

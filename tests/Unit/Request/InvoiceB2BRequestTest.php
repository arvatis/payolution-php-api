<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
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
     * @var  PreCheckXmlMockFactory
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
        $this->xmlMock = new PreCheckXmlMockFactory();
        $this->xmlApi = new XmlApi(new ApiClient(new Client()));
    }

    /**
     * @group online
     */
    public function testPreCheckSuccessFull()
    {
        $client = ApiFactory::createXmlApi();
        $request = PreCheckXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE_B2B,
            RequestTypes::PRE_CHECK
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Requst was' . print_r($request->saveXML(), true) . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    /**
     * @group online
     */
    public function testPreAuthSuccessFull()
    {
        $client = ApiFactory::createXmlApi();
        $request = PreCheckXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE_B2B,
            RequestTypes::PRE_AUTH
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Requst was' . print_r($request->saveXML(), true) . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }
}

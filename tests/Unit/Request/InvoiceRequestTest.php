<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
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
        $response = $client->doRequest(PreCheckXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE,
            RequestTypes::PRE_CHECK)
        );

        self::assertTrue($response->getSuccess());
    }
}

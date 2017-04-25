<?php


namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;
use GuzzleHttp\Client;

/**
 * Class InvoiceRequestTest
 * @group Invoice
 */
class InvoiceRequestTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @var XmlApi
     */
    private $xmlApi;
    /**
     * @var  PreCheckXmlMockFactory
     */
    protected $xmlMock;

    /**
     * @var XmlSerializer
     */
    protected $xmlSerializer;

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
        $client = new XmlApi(new ApiClient());
        $response = $client->doRequest(PreCheckXmlMockFactory::getRequestXml('Invoice', 'PreCheck'));

        self::assertTrue($response->getSuccess());
    }

}

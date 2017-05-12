<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class ElvTest
 *
 * @group ElvTest
 */
class ElvTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var  RequestXmlMockFactory
     */
    protected $xmlMock;

    /**
     * @var XmlApi
     */
    private $xmlApi;

    public function setUp()
    {
        $this->xmlMock = new RequestXmlMockFactory();
        $this->xmlApi = ApiFactory::createXmlApi();
    }

    /**
     * @group online
     */
    public function testPreCheckSuccessful()
    {
        $client = ApiFactory::createXmlApi();
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_ELV,
            RequestTypes::PRE_CHECK
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    /**
     * @group online
     */
    public function testPreAuthSuccessful()
    {
        $this->markTestSkipped(); //TODO: implement
        $client = ApiFactory::createXmlApi();
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_ELV,
            RequestTypes::PRE_AUTH
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }
}

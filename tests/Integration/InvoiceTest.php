<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class InvoiceTest
 *
 * @group InvoiceTest
 */
class InvoiceTest extends \PHPUnit_Framework_TestCase
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
    public function testPreCheckSuccessFull()
    {
        $response = $this->xmlApi->doRequest(RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE,
            RequestTypes::PRE_CHECK)
        );

        self::assertTrue($response->getSuccess());
    }
}

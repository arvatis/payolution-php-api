<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class InvoiceB2BTest
 *
 * @group InvoiceB2BTest
 */
class InvoiceB2BTest extends \PHPUnit_Framework_TestCase
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
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE_B2B,
            RequestTypes::PRE_CHECK
        );
        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Reqeust was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    /**
     * @group online
     */
    public function testPreAuthSuccessful()
    {
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE_B2B,
            RequestTypes::PRE_AUTH
        );
        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Reqeust was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }
}

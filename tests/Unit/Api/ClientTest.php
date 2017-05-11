<?php

namespace ArvPayolutionApi\Unit\Api;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class ClientTest
 */
class ClientTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @group online
     * @group testBasicRequestSuccessfullyPlaced
     */
    public function testBasicRequestSuccessfullyPlaced()
    {
        $client = ApiFactory::createXmlApi();
        $response = $client->doRequest(RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INVOICE,
            RequestTypes::PRE_CHECK)
        );

        self::assertTrue($response->getSuccess(), 'Transaction id was: ' . $response->getUniqueID());
    }

    /**
     * @group online
     */
    public function testInvalidRequest()
    {
        $response = $this->xmlApi->doRequest(new \SimpleXMLElement('<xml></xml>'));

        //print_r($response);
        self::assertSame(' NOK REJECTED_VALIDATION  Format Error', $response->getErrorMessage());
    }

    /**
     * @group online
     */
    public function testDoPreCheckWithRandomData()
    {
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => $this->data->getCustomer(),
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
        ];

        $requestType = 'PreCheck';
        $paymentBrand = 'PAYOLUTION_INVOICE';
        $isPreCheck = true;

        $response = $this->xmlApi->doRequest(
            RequestFactory::create($requestType, $paymentBrand, $data, $isPreCheck)
        );
        self::assertSame('VA.PA.60.95 NOK REJECTED_BANK  Authorization Error', $response->getErrorMessage());
    }

    /**
     * @expectedException
     */
    public function testClientErrorResponses()
    {
        $mock = new MockHandler([
            new Response(404, []),
            new Response(500, []),
            new RequestException('Error Communicating with Server', new Request('POST', 'test')),
        ]);

        $handler = HandlerStack::create($mock);
        $clientMock = new Client(['handler' => $handler]);
        $this->xmlApi->setClient(new ApiClient($clientMock));

        $requestData = new \SimpleXMLElement('<xml></xml>');
        $response = $this->xmlApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Client error: `POST ' . XmLAPI::URL_XML_API_SANDBOX . '` resulted in a `404 Not Found` response:'
                    . PHP_EOL . PHP_EOL,
                'status' => '',
                'transactionID' => '',
            ],
            $response->jsonSerialize(),
            true,
            'response was: ' . print_r($response->jsonSerialize(), true)
        );

        $response = $this->xmlApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Server error: `POST ' . XmLAPI::URL_XML_API_SANDBOX . '` resulted in a `500 Internal Server Error` response:'
                    . PHP_EOL . PHP_EOL,
                'status' => '',
                'transactionID' => '',
            ],
            $response->jsonSerialize(),
            true,
            'response was: ' . print_r($response->jsonSerialize(), true)
        );

        $response = $this->xmlApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Error Communicating with Server',
                'status' => '',
                'transactionID' => '',
            ],
            $response->jsonSerialize(),
            true,
            'response was: ' . print_r($response->jsonSerialize(), true)
        );
    }
}

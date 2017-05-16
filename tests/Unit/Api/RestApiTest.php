<?php

namespace ArvPayolutionApi\Unit\Api;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\RestApi;
use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\Invoice\RequestDataGenerated;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
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
 * Class RestApiTest
 */
class RestApiTest extends \PHPUnit_Framework_TestCase
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
     * @var RestApi
     */
    private $restApi;

    /** @var RequestDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->data = new RequestDataGenerated();
        $this->xmlSerializer = XmlSerializerFactory::create();
        $this->xmlMock = new RequestXmlMockFactory();
        $config = Config::getPaymentConfig('Installment', RequestTypes::CALCULATION);
        $this->restApi = ApiFactory::createRestApi($config['user'], $config['password']);
    }

    /**
     * @group online
     */
    public function testInvalidRequest()
    {
        $response = $this->restApi->doRequest(new \SimpleXMLElement('<xml></xml>'));

        //print_r($response);
        self::assertSame('1.8.0 ERROR', $response->getErrorMessage());
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
        $this->restApi->setClient(new ApiClient($clientMock));

        $requestData = new \SimpleXMLElement('<xml></xml>');
        $response = $this->restApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Client error: `POST ' . $this->restApi::URL_SANDBOX . '` resulted in a `404 Not Found` response:'
                    . PHP_EOL . PHP_EOL,
                'status' => '',
                'transactionID' => '',
            ],
            $response->jsonSerialize(),
            true,
            'response was: ' . print_r($response->jsonSerialize(), true)
        );

        $response = $this->restApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Server error: `POST ' . $this->restApi::URL_SANDBOX . '` resulted in a `500 Internal Server Error` response:'
                    . PHP_EOL . PHP_EOL,
                'status' => '',
                'transactionID' => '',
            ],
            $response->jsonSerialize(),
            true,
            'response was: ' . print_r($response->jsonSerialize(), true)
        );

        $response = $this->restApi->doRequest($requestData);

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

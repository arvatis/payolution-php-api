<?php



namespace Payolution\Tests\Unit\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Payolution\Api\Client as ApiClient;
use Payolution\Request\RequestFactory;
use Payolution\Request\XmlSerializerFactory;
use Payolution\Api\XmlApi;
use Payolution\Tests\Mocks\Request\Invoice\PreCheckDataGenerated;
use Payolution\Tests\Mocks\Request\PreCheckXmlMockFactory;

/**
 * Class ClientTest
 */
class ClientTest extends \PHPUnit_Framework_TestCase
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
    public function testBasicRequestSuccessfullyPlaced()
    {
        $client = new XmlApi(new ApiClient());
        $response = $client->doRequest(PreCheckXmlMockFactory::getRequestXml('Invoice', 'PreCheck'));

        self::assertTrue($response->getSuccess());
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
            new \SimpleXMLElement($this->xmlSerializer->serialize(
                [
                    '@version' => '1.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data, $isPreCheck),
                ],
                true
            )));
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
            $response->toArray(),
            true,
            'response was: ' . print_r($response->toArray(), true)
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
            $response->toArray(),
            true,
            'response was: ' . print_r($response->toArray(), true)
        );

        $response = $this->xmlApi->doRequest($requestData);

        self::assertArraySubset(
            [
                'success' => false,
                'errorMessage' => 'Error Communicating with Server',
                'status' => '',
                'transactionID' => '',
            ],
            $response->toArray(),
            true,
            'response was: ' . print_r($response->toArray(), true)
        );
    }
}

<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\Installment\CalculationData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;
use GuzzleHttp\Client;
use ArvPayolutionApi\Mocks\Request\Installment\PreCheckData as InstallmentPreCheckData;

/**
 * Class InstallmentRequestTest
 *
 * @group InstallmentRequestTest
 */
class InstallmentRequestTest extends \PHPUnit_Framework_TestCase
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
            RequestPaymentTypes::PAYOLUTION_INS,
            RequestTypes::PRE_CHECK
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . print_r($request->saveXML(), true) . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    /**
     * @group online
     */
    public function testPreAuthSuccessFull()
    {
        $this->markTestSkipped(); //TODO
        $client = ApiFactory::createXmlApi();
        $request = PreCheckXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INS,
            RequestTypes::PRE_AUTH
        );
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . print_r($request->saveXML(), true) . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    /**
     * @group online
     */
    public function testCalculationSuccessFull()
    {
        $config = Config::getPaymentConfig('Installment', RequestTypes::CALCULATION);
        $client = ApiFactory::createRestApi($config['user'], $config['password']);
        $request = $this->getCalculationRequestMock();
        $response = $client->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . print_r($request->saveXML(), true) . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }

    public function testCalculationSameAsMock()
    {
        $this->data = new CalculationData();
        $data = [
            'context' => $this->data->getApiContext(),
            'customer' => '',
            'shippingAddress' => $this->data->getShippingAddress(),
            'billingAddress' => $this->data->getCustomerAddress(),
            'cart' => $this->data->getCart(),
            'cartItems' => $this->data->getCartItems(),
            'systemInfo' => $this->data->getSytemInfo(),
            'account' => $this->data->getAccountData(),
            'installment' => $this->data->getInstallmentData(),
        ];

        $requestType = RequestTypes::CALCULATION; // for Pre-Check, Pre- & Re-Authorization,
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $this->assertSame(
            PreCheckXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INS,
                $requestType
            )->saveXml(),
            $this->xmlSerializer->serialize(
                [
                    '@version' => '2.0',
                    '#' => RequestFactory::create($requestType, $paymentBrand, $data),
                ],
                true
            )
        );
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getCalculationRequestMock()
    {
        $filePath = __DIR__ . '/../../Mocks/Request/Installment/Calculation.xml';
        $xmlString = file_get_contents($filePath);

        return new \SimpleXMLElement($xmlString);
    }
}

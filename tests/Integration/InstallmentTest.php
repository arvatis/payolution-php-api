<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\RestApi;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\Installment\PreAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\RequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class InstallmentRequestTest
 *
 * @group InstallmentRequestTest
 */
class InstallmentRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var  RequestXmlMockFactory
     */
    protected $xmlMock;

    /**
     * @var RestApi
     */
    private $restApi;

    /**
     * @var XmlApi
     */
    private $xmlApi;

    /** @var PreCheckDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->data = new PreCheckDataGenerated();
        $this->xmlMock = new RequestXmlMockFactory();
        $this->xmlApi = ApiFactory::createXmlApi();

        $config = Config::getPaymentConfig('Installment', RequestTypes::CALCULATION);
        $this->restApi = ApiFactory::createRestApi($config['user'], $config['password']);
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testPreCheckSuccessFull()
    {
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INS,
            RequestTypes::PRE_CHECK
        );
        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . $response->saveXML()
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testCalculationSuccessFull()
    {
        $request = RequestXmlMockFactory::getRequestXml(RequestPaymentTypes::PAYOLUTION_INS, RequestTypes::CALCULATION);
        $response = $this->restApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . $response->saveXML()
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreCheckSuccessFull
     * @depends testCalculationSuccessFull
     *
     * @param $uniqueIdPreCheck
     * @param $uniqueIdCalculation
     */
    public function testPreAuthSuccessFull($uniqueIdPreCheck, $uniqueIdCalculation)
    {
        $this->data = new PreAuthData();
        $data = $this->data->jsonSerialize();
        $data['installment']['calculationId'] = $uniqueIdCalculation;

        $requestType = RequestTypes::PRE_AUTH;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $request = RequestFactory::create($requestType, $paymentBrand, $data, $uniqueIdPreCheck);

        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'PreCheckId: ' . $uniqueIdPreCheck . PHP_EOL .
            'CalculationId: ' . $uniqueIdCalculation . PHP_EOL .
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . $response->saveXML()
        );
    }
}

<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\RestApi;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Request\Installment\PreAuthData;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class InstallmentTest
 *
 * @group InstallmentTest
 */
class InstallmentTest extends \PHPUnit_Framework_TestCase
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

    public function setUp()
    {
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
    public function testPreCheckSuccessful()
    {
        $request = RequestXmlMockFactory::getRequestXml(
            RequestPaymentTypes::PAYOLUTION_INS,
            RequestTypes::PRE_CHECK
        );
        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testCalculationSuccessful()
    {
        $request = RequestXmlMockFactory::getRequestXml(RequestPaymentTypes::PAYOLUTION_INS, RequestTypes::CALCULATION);
        $response = $this->restApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreCheckSuccessful
     * @depends testCalculationSuccessful
     *
     * @param $uniqueIdPreCheck
     * @param $uniqueIdCalculation
     */
    public function testPreAuthSuccessful($uniqueIdPreCheck, $uniqueIdCalculation)
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();
        $data['installment']['calculationId'] = $uniqueIdCalculation;

        $requestType = RequestTypes::PRE_AUTH;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $request = PreAuthRequestFactory::create($requestType, $paymentBrand, $data, $uniqueIdPreCheck);

        $response = $this->xmlApi->doRequest($request);

        self::assertTrue(
            $response->getSuccess(),
            'PreCheckId: ' . $uniqueIdPreCheck . PHP_EOL .
            'CalculationId: ' . $uniqueIdCalculation . PHP_EOL .
            'Request was' . $request->saveXML() . PHP_EOL .
            'Response was' . print_r($response, true)
        );
    }
}

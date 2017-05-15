<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\CaptureData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckData;
use ArvPayolutionApi\Mocks\Request\Invoice\ReAuthData;
use ArvPayolutionApi\Mocks\Request\Invoice\RefundData;
use ArvPayolutionApi\Mocks\Request\Invoice\ReversalData;
use ArvPayolutionApi\Mocks\Request\RequestXmlMockFactory;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\ReAuthRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;

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
    private $paymentMethod;

    /**
     * @var XmlApi
     */
    private $xmlApi;

    public function setUp()
    {
        $this->xmlMock = new RequestXmlMockFactory();
        $this->xmlApi = ApiFactory::createXmlApi();
        $this->paymentMethod = $paymentBrand = RequestPaymentTypes::PAYOLUTION_INVOICE;
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testPreCheckSuccessful()
    {
        $data = new PreCheckData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_CHECK;

        $response = $this->xmlApi->doRequest(
            PreCheckRequestFactory::create($requestType, $this->paymentMethod, $data)
        );
        self::assertTrue($response->getSuccess());

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreCheckSuccessful
     *
     * @param $preCheckId
     *
     * @return string
     */
    public function testPreAuthSuccessful($preCheckId)
    {
        $response = $this->doPreAuth($preCheckId);
        self::assertTrue($response->getSuccess(),
            'Response was ' . print_r($response, true)
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testReversalSuccessful()
    {
        $preAuth = $this->doPreAuth();
        self::assertTrue($preAuth->getSuccess(),
            'PreAuth failed. ' . $preAuth->getErrorMessage()
        );
        $capture = $this->doCapture($preAuth->getUniqueID());
        self::assertTrue($capture->getSuccess(),
            'Capture failed. Response was ' . $capture->getXml()->saveXML()
        );

        $data = new ReversalData();
        $data = $data->jsonSerialize();

        $request = ReversalRequestFactory::create(
            RequestTypes::REVERSAL,
            $this->paymentMethod,
            $data,
            $preAuth->getUniqueID()
        );
        $response = $this->xmlApi->doRequest($request);
        self::assertTrue($response->getSuccess(),
            'PreAuthId was ' . $preAuth->getUniqueID() . PHP_EOL .
            'Capture was ' . $capture->getUniqueID() . PHP_EOL .
            'Request was ' . $request->saveXML() . PHP_EOL .
            'Response was ' . ($response->getXml() ? $response->getXml()->saveXML() : print_r($response, true))
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreAuthSuccessful
     *
     * @param $preAuth
     *
     * @return string
     */
    public function testCaptureSuccessful($preAuth)
    {
        $response = $this->doCapture($preAuth);

        self::assertTrue($response->getSuccess(),
            'Response was ' . print_r($response, true));

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreAuthSuccessful
     * @depends testPreAuthSuccessful
     *
     * @param $preAuth
     *
     * @return string
     */
    public function testRefundSuccessful($preAuth)
    {
        $data = new RefundData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::REFUND;

        $request = RefundRequestFactory::create($requestType, $this->paymentMethod, $data, $preAuth);
        $response = $this->xmlApi->doRequest(
            $request
        );
        self::assertTrue(
            $response->getSuccess(),
            'Request was ' . $request->saveXML() . PHP_EOL .
            'Response was ' . print_r($response, true));

        return $response->getUniqueID();
    }

    /**
     * @group online
     *
     * @return \ArvPayolutionApi\Response\ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    public function testReAuthSuccessful()
    {
        $preAuth = $this->doPreAuth();
        self::assertTrue($preAuth->getSuccess(),
            'PreAuth failed. Response was ' . $preAuth->getXml()->saveXML()
        );

        $data = new ReAuthData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::RE_AUTH;

        $request = ReAuthRequestFactory::create($requestType, $this->paymentMethod, $data, $preAuth->getUniqueID());
        $response = $this->xmlApi->doRequest(
            $request
        );
        self::assertTrue(
            $response->getSuccess(),
            'Request was ' . $request->saveXML() . PHP_EOL .
            'Response was ' . print_r($response, true));

        return $response;
    }

    /**
     * @param null $preCheckId
     *
     * @return \ArvPayolutionApi\Response\ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doPreAuth($preCheckId = null)
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::PRE_AUTH;

        $request = PreAuthRequestFactory::create($requestType, $this->paymentMethod, $data, $preCheckId);
        $response = $this->xmlApi->doRequest(
            $request
        );

        return $response;
    }

    /**
     * @param $preAuthUniqueId
     *
     * @return \ArvPayolutionApi\Response\ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doCapture($preAuthUniqueId)
    {
        $data = new CaptureData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::CAPTURE;

        $request = CaptureRequestFactory::create($requestType, $this->paymentMethod, $data, $preAuthUniqueId);
        $response = $this->xmlApi->doRequest(
            $request
        );

        return $response;
    }
}

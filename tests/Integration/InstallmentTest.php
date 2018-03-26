<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\RestApi;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Helpers\TransactionHelper;
use ArvPayolutionApi\Mocks\Config;
use ArvPayolutionApi\Mocks\Request\Installment\CalculationData;
use ArvPayolutionApi\Mocks\Request\Installment\CaptureData;
use ArvPayolutionApi\Mocks\Request\Installment\PreAuthData;
use ArvPayolutionApi\Mocks\Request\Installment\PreCheckData;
use ArvPayolutionApi\Mocks\Request\Installment\ReAuthData;
use ArvPayolutionApi\Mocks\Request\Installment\RefundData;
use ArvPayolutionApi\Mocks\Request\Installment\ReversalData;
use ArvPayolutionApi\Request\CalculationRequestFactory;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\ReAuthRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\RequestTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;
use ArvPayolutionApi\Response\ResponseContract;

/**
 * Class InstallmentTest
 *
 * @group InstallmentTest
 */
class InstallmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RestApi
     */
    private $restApi;

    /**
     * @var XmlApi
     */
    private $xmlApi;

    /**
     * @var string
     */
    private $paymentMethod;

    protected function setUp()
    {
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INS;
        $this->xmlApi = ApiFactory::createXmlApi();

        $config = Config::getPaymentConfig('Installment', RequestTypes::CALCULATION);
        $this->restApi = ApiFactory::createRestApi($config['user'], $config['password']);
    }

    /**
     * @group online
     *
     * @return ResponseContract
     */
    public function testPreCheckSuccessful()
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);

        $response = $this->doPreCheck($transactionId);

        self::assertTrue(
            $response->getSuccess(),
            'Response was ' . $response->getErrorMessage()
        );

        return $response;
    }

    /**
     * @group online
     *
     * @return ResponseContract
     */
    public function testCalculationSuccessful()
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);

        $response = $this->doCaculation($transactionId);

        self::assertTrue(
            $response->getSuccess(),
            'Response was ' . $response->getErrorMessage()
        );

        return $response;
    }

    /**
     * @group online
     * @depends testPreCheckSuccessful
     * @depends testCalculationSuccessful
     *
     * @param ResponseContract $preCheck
     * @param ResponseContract $calculation
     *
     * @return ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    public function testPreAuthSuccessful($preCheck, $calculation)
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);

        $response = $this->doPreAuth($calculation, $preCheck, $transactionId);

        self::assertTrue(
            $response->getSuccess(),
            'PreCheckId: ' . $preCheck->getUniqueID() . PHP_EOL .
            'CalculationId: ' . $calculation->getUniqueID() . PHP_EOL .
            'Response was' . $response->getErrorMessage()
        );

        return $response;
    }

    /**
     * @group online
     * @depends testPreAuthSuccessful
     *
     * @param ResponseContract $preAuth
     *
     * @return ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    public function testReAuthSuccessful($preAuth)
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);

        $data = new ReAuthData();
        $data = $data->jsonSerialize();
        $data['context']['transactionId'] = $transactionId;

        $request = ReAuthRequestFactory::create($this->paymentMethod, $data, $preAuth->getUniqueID());
        $response = $this->xmlApi->doRequest(
            $request
        );
        self::assertTrue(
            $response->getSuccess(),
            'Request was failed response was ' . $response->getErrorMessage()
        );

        return $response;
    }

    /**
     * @group online
     * @depends testReAuthSuccessful
     *
     * @param ResponseContract $reAuth
     *
     * @return ResponseContract
     */
    public function testCaptureSuccessful($reAuth)
    {
        $response = $this->doCapture($reAuth);

        self::assertTrue($response->getSuccess(),
            'Capture ' . $response->getUniqueID() . ' failed with error ' . $response->getErrorMessage() . PHP_EOL .
            'ReAuth Request: ' . print_r($reAuth, true) . PHP_EOL .
            'Capture Request: ' . print_r($response, true) . PHP_EOL
        );

        return $response;
    }

    /**
     * @group online
     * @depends testCaptureSuccessful
     *
     * @param ResponseContract $reAuth
     *
     * @return string
     */
    public function testRefundSuccessful($reAuth)
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);

        $data = new RefundData();
        $data = $data->jsonSerialize();
        $data['context']['transactionId'] = $transactionId;

        $request = RefundRequestFactory::create($this->paymentMethod, $data, $reAuth->getUniqueID());
        $response = $this->xmlApi->doRequest($request);
        self::assertTrue($response->getSuccess(),
            'PreAuthId was ' . $reAuth->getUniqueID() . PHP_EOL .
            'Response was ' . $response->getErrorMessage()
        );

        return $response;
    }

    /**
     * @group online
     *
     * @return string
     */
    public function testReversalSuccessful()
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);
        $caculation = $this->doCaculation($transactionId);
        self::assertTrue(
            $caculation->getSuccess(),
            'Calculation failed: ' . $caculation->getErrorMessage()
        );
        $preAuth = $this->doPreAuth($caculation, null, $transactionId);
        self::assertTrue(
            $preAuth->getSuccess(),
            'PreAuth failed: ' . $preAuth->getErrorMessage()
        );

        $data = new ReversalData();
        $data = $data->jsonSerialize();
        $data['context']['transactionId'] = $preAuth->getTransactionID();

        $request = ReversalRequestFactory::create($this->paymentMethod, $data, $preAuth->getUniqueID());
        $response = $this->xmlApi->doRequest(
            $request
        );
        self::assertTrue(
            $response->getSuccess(),
            'Request was failed response was ' . $response->getErrorMessage()
        );

        return $response->getUniqueID();
    }

    /**
     * @param ResponseContract $calculation
     * @param null $preCheckId
     * @param null $transactionId
     *
     * @return ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doPreAuth($calculation, $preCheckId = null, $transactionId = null)
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();
        $data['installment']['calculationId'] = $calculation->getUniqueID();
        $data['context']['transactionId'] = $transactionId;

        $request = PreAuthRequestFactory::create($this->paymentMethod, $data, $preCheckId);

        $response = $this->xmlApi->doRequest($request);

        return $response;
    }

    /**
     * @param ResponseContract $preAuth
     *
     * @return \ArvPayolutionApi\Response\ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doCapture(ResponseContract $preAuth)
    {
        $data = new CaptureData();
        $data = $data->jsonSerialize();

        $data['context']['transactionId'] = $preAuth->getTransactionID();

        $request = CaptureRequestFactory::create($this->paymentMethod, $data, $preAuth->getUniqueID());
        $response = $this->xmlApi->doRequest(
            $request
        );

        return $response;
    }

    /**
     * @param $transactionID
     *
     * @return ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doPreCheck($transactionID)
    {
        $data = new PreCheckData();
        $data = $data->jsonSerialize();
        $data['context']['transactionId'] = $transactionID;

        $request = PreCheckRequestFactory::create($this->paymentMethod, $data);
        $response = $this->xmlApi->doRequest(
            $request
        );

        return $response;
    }

    /**
     * @param $transactionId
     *
     * @return ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doCaculation($transactionId)
    {
        $data = new CalculationData();
        $data = $data->jsonSerialize();
        $data['context']['transactionId'] = $transactionId;
        print_r($data['context']);
        $request = CalculationRequestFactory::create($this->paymentMethod, $data);
        $response = $this->restApi->doRequest($request);
//var_export($response->getPaymentPlans());
        return $response;
    }
}

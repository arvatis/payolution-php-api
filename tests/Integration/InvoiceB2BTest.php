<?php

namespace ArvPayolutionApi\Integration;

use ArvPayolutionApi\Api\ApiFactory;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Helpers\TransactionHelper;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\CaptureData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\PreCheckData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\ReAuthData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\RefundData;
use ArvPayolutionApi\Mocks\Request\InvoiceB2B\ReversalData;
use ArvPayolutionApi\Request\CaptureRequestFactory;
use ArvPayolutionApi\Request\PreAuthRequestFactory;
use ArvPayolutionApi\Request\PreCheckRequestFactory;
use ArvPayolutionApi\Request\ReAuthRequestFactory;
use ArvPayolutionApi\Request\RefundRequestFactory;
use ArvPayolutionApi\Request\RequestPaymentTypes;
use ArvPayolutionApi\Request\ReversalRequestFactory;
use ArvPayolutionApi\Response\ResponseContract;

/**
 * Class InvoiceB2BTest
 *
 * @group InvoiceB2BTest
 */
class InvoiceB2BTest extends \PHPUnit_Framework_TestCase
{
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
        $this->xmlApi = ApiFactory::createXmlApi();
        $this->paymentMethod = RequestPaymentTypes::PAYOLUTION_INVOICE_B2B;
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

        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);
        $data['context']['transactionId'] = $transactionId;

        $response = $this->xmlApi->doRequest(PreCheckRequestFactory::create($this->paymentMethod, $data));
        self::assertTrue(
            $response->getSuccess(),
            'Request was failed response was ' . $response->getErrorMessage()
        );

        return $response->getUniqueID();
    }

    /**
     * @group online
     * @depends testPreCheckSuccessful
     *
     * @param $preCheckId
     *
     * @return ResponseContract
     */
    public function testPreAuthSuccessful($preCheckId)
    {
        $transactionId = TransactionHelper::getUniqueTransactionId(__METHOD__);
        $response = $this->doPreAuth($preCheckId, $transactionId);
        self::assertTrue(
            $response->getSuccess(),
            'Request was failed response was ' . $response->getErrorMessage()
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
     * @return string
     */
    public function testCaptureSuccessful($reAuth)
    {
        $response = $this->doCapture($reAuth);

        self::assertTrue($response->getSuccess(),
            'Response was ' . print_r($response, true));

        return $reAuth;
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
        $preAuth = $this->doPreAuth(null, $transactionId);
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
     * @param null $preCheckId
     * @param null $transactionId
     *
     * @return \ArvPayolutionApi\Response\ResponseContract|\ArvPayolutionApi\Response\XmlApiResponse
     */
    private function doPreAuth($preCheckId = null, $transactionId = null)
    {
        $data = new PreAuthData();
        $data = $data->jsonSerialize();

        if (!empty($transactionId)) {
            $data['context']['transactionId'] = $transactionId;
        }
        $request = PreAuthRequestFactory::create($this->paymentMethod, $data, $preCheckId);
        $response = $this->xmlApi->doRequest(
            $request
        );

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
}

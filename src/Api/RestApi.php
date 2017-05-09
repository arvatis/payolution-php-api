<?php

namespace ArvPayolutionApi\Api;

use ArvPayolutionApi\Response\ClientErrorResponse;
use ArvPayolutionApi\Response\ResponseContract;
use ArvPayolutionApi\Response\RestApiResponse;
use ArvPayolutionApi\Response\XmlApiResponse;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class RestApi
 */
class RestApi
{
    const URL_PRODUCTION = 'https://payment.payolution.com/payolution-payment/rest/request/v2';
    const URL_SANDBOX = 'https://test-payment.payolution.com/payolution-payment/rest/request/v2';

    /**
     * @var  ClientContract
     */
    protected $client;
    /**
     * @var bool
     */
    protected $testMode;

    /**
     * XmlApi constructor.
     *
     * @param ClientContract $client
     * @param bool $testMode
     */
    public function __construct(ClientContract $client, $testMode = true)
    {
        $this->client = $client;
        $this->testMode = $testMode;
        $this->initClient($client);
    }

    /**
     * @return ClientContract
     */
    public function getClient(): ClientContract
    {
        return $this->client;
    }

    /**
     * @param ClientContract $client
     *
     * @return RestApi
     */
    public function setClient(ClientContract $client): RestApi
    {
        $this->client = $client;
        $this->initClient($client);

        return $this;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return ResponseContract|XmlApiResponse
     */
    public function doRequest(\SimpleXMLElement $xml): ResponseContract
    {
        try {
            $responseBody = $this->client->doRequest(urlencode($xml->asXML()));

            return new RestApiResponse(new \SimpleXMLElement($responseBody));
        } catch (ClientException $e) {
        } catch (ServerException $e) {
        } catch (BadResponseException $e) {
        } catch (\Exception $e) {
        }

        return new ClientErrorResponse($e->getMessage());
    }

    public function setBasicAuthCredentials($basicAuthUser, $basicAuthPassword)
    {
        $this->getClient()->addHeader(
            'Authorization', 'Basic ' . base64_encode($basicAuthUser . ':' . $basicAuthPassword)
        );
    }

    /**
     * @return string
     */
    protected function getEndPointUrl()
    {
        if (!$this->testMode) {
            return self::URL_PRODUCTION;
        }

        return self::URL_SANDBOX;
    }

    /**
     * @param ClientContract $client
     */
    private function initClient(ClientContract $client)
    {
        $client->setEndpointUrl($this->getEndPointUrl());
        $client->setMethod('POST');
        $client->addHeader('Content-Type', 'text/xml; charset=UTF8');
    }
}

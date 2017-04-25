<?php



namespace ArvPayolutionApi\Api;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use ArvPayolutionApi\Response\ClientErrorResponse;
use ArvPayolutionApi\Response\ResponseContract;
use ArvPayolutionApi\Response\XmlApiResponse;

/**
 * Class XmlApi
 */
class XmlApi
{

    const URL_XML_API = 'https://gateway.payolution.com/ctpe/api';
    const URL_XML_API_SANDBOX = 'https://test-gateway.payolution.com/ctpe/api';

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
     * @return XmlApi
     */
    public function setClient(ClientContract $client): XmlApi
    {
        $this->client = $client;
        $this->initClient($client);

        return $this;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return ResponseContract|XmlApiResponse
     */
    public function doRequest(\SimpleXMLElement $xml): ResponseContract
    {
        try {
            $responseBody = $this->client->doRequest('load=' . urlencode($xml->asXML()));

            return new XmlApiResponse(new \SimpleXMLElement($responseBody));

        } catch (ClientException $e) {
        } catch (ServerException $e) {
        } catch (BadResponseException $e) {
        } catch (\Exception $e) {
        }
        return new ClientErrorResponse($e->getMessage());
    }

    /**
     * @return string
     */
    protected function getEndPointUrl(): string
    {
        if (!$this->testMode) {
            return self::URL_XML_API;
        }

        return self::URL_XML_API_SANDBOX;
    }

    /**
     * @param ClientContract $client
     */
    private function initClient(ClientContract $client)
    {
        $client->setEndpointUrl($this->getEndPointUrl());
        $client->setMethod('POST');
        $client->addHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
    }
}

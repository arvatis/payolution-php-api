<?php



namespace ArvPayolutionApi\Api;

use GuzzleHttp\ClientInterface;

/**
 * Class Client
 */
class Client implements ClientContract
{
    /**
     * @var  string
     */
    protected $url;
    /**
     * @var  string
     */
    protected $client;
    /**
     * @var  string
     */
    protected $httpMethod;
    /**
     * @var  string[]
     */
    protected $headers;

    /**
     * Client constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        if ($client) {
            $this->client = $client;
            return;
        }
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     *
     * @return Client
     */
    public function setClient(\GuzzleHttp\Client $client): Client
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return (string)$this->httpMethod;
    }

    /**
     * @param string $httpMethod
     *
     * @return Client
     */
    public function setHttpMethod($httpMethod): Client
    {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndpointUrl()
    {
        return (string)$this->url;
    }

    /**
     * @param mixed $url
     *
     * @return Client
     */
    public function setEndpointUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param string $body
     *
     * @return string
     */
    public function doRequest($body)
    {
        $res = $this->client->request(
            $this->getHttpMethod(),
            $this->getEndpointUrl(),
            [
                'body' => $body,
                'headers' => $this->headers,
            ]
        );

        return (string)$res->getBody();
    }

    /**
     * @param $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->httpMethod = $method;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value)
    {
        if (!$this->headers) {
            $this->headers = [];
        }
        $this->headers[$key] = $value;
    }
}

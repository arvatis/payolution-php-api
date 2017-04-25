<?php



namespace ArvPayolutionApi\Api;

/**
 * Interface ClientContract
 */
interface ClientContract
{
    /**
     * @param string $body
     *
     * @return string
     */
    public function doRequest($body);

    /**
     * @param string $method
     */
    public function setMethod($method);

    /**
     * @param string $url
     */
    public function setEndpointUrl($url);

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value);
}

<?php

namespace ArvPayolutionApi\Unit\Api;

use ArvPayolutionApi\Api\Client as ApiClient;
use ArvPayolutionApi\Api\RestApi;
use ArvPayolutionApi\Api\XmlApi;
use ArvPayolutionApi\Mocks\Request\Invoice\PreCheckDataGenerated;
use ArvPayolutionApi\Mocks\Request\PreCheckXmlMockFactory;
use ArvPayolutionApi\Request\XmlSerializer;
use ArvPayolutionApi\Request\XmlSerializerFactory;
use GuzzleHttp\Client;

/**
 * Class RestApiTest
 */
class RestApiTest extends \PHPUnit_Framework_TestCase
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
    private $restApi;

    /** @var PreCheckDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->data = new PreCheckDataGenerated();
        $this->xmlSerializer = XmlSerializerFactory::create();
        $this->xmlMock = new PreCheckXmlMockFactory();
        $this->restApi = new RestApi(new ApiClient(new Client()));
    }
}

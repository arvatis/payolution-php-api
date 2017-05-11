<?php

namespace ArvPayolutionApi\Unit\Request;

use ArvPayolutionApi\Mocks\Request\Installment\CalculationData;
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

    /** @var PreCheckDataGenerated $data */
    private $data;

    public function setUp()
    {
        $this->data = new PreCheckDataGenerated();
        $this->xmlMock = new RequestXmlMockFactory();
    }

    public function testCalculationSameAsMock()
    {
        $data = new CalculationData();
        $data = $data->jsonSerialize();

        $requestType = RequestTypes::CALCULATION;
        $paymentBrand = RequestPaymentTypes::PAYOLUTION_INS;

        $this->assertSame(
            RequestXmlMockFactory::getRequestXml(
                RequestPaymentTypes::PAYOLUTION_INS,
                $requestType
            )->saveXml(),
            RequestFactory::create($requestType, $paymentBrand, $data)->saveXml()
        );
    }
}

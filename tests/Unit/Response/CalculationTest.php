<?php

namespace ArvPayolutionApi\Unit\Response;

use ArvPayolutionApi\Response\RestApiResponse;

/**
 * Class InvoiceRequestTest
 *
 * @group InvoiceB2BRequestTest
 */
class CalculationTest extends \PHPUnit_Framework_TestCase
{
    public function testResponseParsing()
    {
        $response = new RestApiResponse($this->getCalculationResponseMock());

        self::assertTrue($response->getSuccess());
        self::assertSame('4ab2', $response->getTransactionID());
        self::assertSame('Tx-cw2t2f8g6ap', $response->getUniqueID());

        $installments = $response->getPaymentPlans();

        self::assertSame(6, count($installments));
        self::assertSame(3, count($installments[3]['installments']));
    }

    /**
     * @return \SimpleXMLElement
     */
    private function getCalculationResponseMock()
    {
        $filePath = __DIR__ . '/../../Mocks/Request/Installment/Response/Calculation.xml';
        $xmlString = file_get_contents($filePath);

        return new \SimpleXMLElement($xmlString);
    }
}

<?php

namespace ArvPayolutionApi\Unit\Response;

use ArvPayolutionApi\Response\XmlApiResponse;

/**
 * Class XmlApiResponseTest
 */
class XmlApiResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessResponseCreation()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Response version="1.0">
    <Transaction mode="CONNECTOR_TEST" channel="ff8080813b227bf4013b3d661a7c0f86">
        <Identification>
            <ShortID>3619.7673.8466</ShortID>
            <UniqueID>8a82944a5ca14e22015ca166459a471b</UniqueID>
            <TransactionID>basket-7571</TransactionID>
        </Identification>
        <Payment code="VA.PA">
            <Clearing>
                <Amount>103.99</Amount>
                <Currency>EUR</Currency>
                <Descriptor>3619.7673.8466 inv-ins-precheck Cart 7571</Descriptor>
                <FxRate>1.0</FxRate>
                <FxSource>INTERN</FxSource>
                <FxDate>2017-06-13 12:20:53</FxDate>
            </Clearing>
        </Payment>
        <Processing code="VA.PA.90.00">
            <Timestamp>2017-06-13 12:21:03</Timestamp>
            <Result>ACK</Result>
            <Status code="90">NEW</Status>
            <Reason code="00">Successful Processing</Reason>
            <Return code="000.100.112">Request successfully processed in 'Merchant in Connector Test Mode'</Return>
            <Risk score="0"/>
            <ConnectorDetails>
                <Result name="AcquirerResponse">0.0.0</Result>
                <Result name="ConnectorTxID1">Tx-2hedntcbric</Result>
                <Result name="PaymentReference">TRNH-FHTF-NSPB</Result>
            </ConnectorDetails>
        </Processing>
    </Transaction>
</Response>
XML;

        $xmlApiResponse = new XmlApiResponse(new \SimpleXMLElement($xml));
        self::assertTrue($xmlApiResponse->getSuccess());
        self::assertSame('8a82944a5ca14e22015ca166459a471b', $xmlApiResponse->getUniqueID());
        self::assertSame('TRNH-FHTF-NSPB', $xmlApiResponse->getPaymentReference());
        $xmlApiResponseData = $xmlApiResponse->jsonSerialize();
        self::assertTrue($xmlApiResponseData['success']);
        self::assertSame('8a82944a5ca14e22015ca166459a471b', $xmlApiResponseData['uniqueID']);
        self::assertSame('TRNH-FHTF-NSPB', $xmlApiResponseData['paymentReference']);
    }

    public function testErrorResponseCreation()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Response version="1.0">
  <Transaction mode="CONNECTOR_TEST" channel="ff8080813b227bf4013b3d661a7c0f86">
    <Identification>
      <ShortID>0304.7960.4386</ShortID>
      <UniqueID>ff8080813b227be1013b3d735b1e70b7</UniqueID>
      <TransactionID>42</TransactionID>
    </Identification>
    <Payment code="VA.PA">
      <Clearing>
        <Amount>249.99</Amount>
        <Currency>EUR</Currency>

        <FxRate>1.0</FxRate>
        <FxSource>INTERN</FxSource>
        <FxDate>2012-11-26 16:01:08</FxDate>
      </Clearing>
    </Payment>
    <Processing code="VA.PA.60.95">
      <Timestamp>2012-11-26 16:01:22</Timestamp>
      <Result>NOK</Result>
      <Status code="60">REJECTED_BANK</Status>
      <Reason code="95">Authorization Error</Reason>
      <Return code="800.100.170">transaction declined (transaction not permitted)</Return>
      <Risk score="0" />
      <ConnectorDetails>
        <Result name="ConnectorTxID1">LVQT-MFPM-QHSQ</Result>
        <Result name="PaymentReference">LVQT-MFPM-QHSQ</Result>
      </ConnectorDetails>
    </Processing>
  </Transaction>
</Response>
XML;

        $xmlApiResponse = new XmlApiResponse(new \SimpleXMLElement($xml));
        self::assertTrue(!$xmlApiResponse->getSuccess());
        self::assertSame('', $xmlApiResponse->getUniqueID());
        self::assertSame('VA.PA.60.95 NOK REJECTED_BANK  Authorization Error transaction declined (transaction not permitted)',
            $xmlApiResponse->getErrorMessage());
    }
}

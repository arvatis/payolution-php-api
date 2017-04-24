<?php



namespace Payolution\Tests\Unit\Request;

use Payolution\Api\Request\Header;
use Payolution\Api\Request\XmlSerializer;
use Payolution\Api\Request\XmlSerializerFactory;
use Payolution\Request\Transaction\Analysis;
use Payolution\Request\Transaction\Payment;
use Payolution\Request\Transaction\Payment\Presentation;

/**
 * Class XmlSerializerTest
 */
class XmlSerializerTest extends \PHPUnit_Framework_TestCase
{
    protected $presentation;
    /**
     * @var XmlSerializer
     */
    protected $xmlSerializer;

    public function setUp()
    {
        $this->presentation = new Presentation(249.99, 'Trx 42', 'EUR');
        $this->xmlSerializer = XmlSerializerFactory::create();
    }

    public function testAttributeConversion()
    {
        $xml = <<<XML
<Header>
  <Security sender="8a8294182f965dd4012f9b5c54f50169"/>
</Header>
XML;

        $this->assertSame($xml, $this->xmlSerializer->serialize(new Header('8a8294182f965dd4012f9b5c54f50169')));
    }

    public function testNestedObjectConversion()
    {
        $xml = <<<XML
<Payment>
  <Presentation>
    <Amount>249.99</Amount>
    <Usage>Trx 42</Usage>
    <Currency>EUR</Currency>
  </Presentation>
</Payment>
XML;
        $payment = new Payment('VA.PA', $this->presentation);
        $this->assertSame(
            $xml,
            $this->xmlSerializer->serialize(
                $payment
            )
        );
    }

    public function testSimpleObjectConversion()
    {
        $xml = <<<XML
<Presentation>
  <Amount>249.99</Amount>
  <Usage>Trx 42</Usage>
  <Currency>EUR</Currency>
</Presentation>
XML;

        $this->assertSame($xml, $this->xmlSerializer->serialize($this->presentation));
    }

    public function testListOfAttributes()
    {
        $xml = <<<XML
<Analysis>
  <Criterion name="PAYOLUTION_REQUEST_SYSTEM_VENDOR">CustomSystemName_ProgrammingLanguage_XML</Criterion>
  <Criterion name="PAYOLUTION_REQUEST_SYSTEM_VERSION">CustomSystemVersion</Criterion>
  <Criterion name="PAYOLUTION_REQUEST_SYSTEM_TYPE">Webshop</Criterion>
</Analysis>
XML;
        $analysis = new Analysis();
        $analysis->addCriterion('PAYOLUTION_REQUEST_SYSTEM_VENDOR',
            'CustomSystemName_ProgrammingLanguage_XML');
        $analysis->addCriterion('PAYOLUTION_REQUEST_SYSTEM_VERSION', 'CustomSystemVersion');
        $analysis->addCriterion('PAYOLUTION_REQUEST_SYSTEM_TYPE', 'Webshop');
        $this->assertSame($xml, $this->xmlSerializer->serialize($analysis));
    }
}

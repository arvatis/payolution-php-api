<?php



namespace Payolution\Request\Transaction\Analysis;

use Payolution\Request\RequestTypes;

/**
 * Class Shipping
 */
class Invoice extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->requestType == RequestTypes::CAPTURE;
    }

    /**
     * @return array
     */
    public function collect()
    {
        $invoice = $this->data['invoice'];

        return [
            CriterionNames::PAYOLUTION_INVOICE_ID => $invoice['invoiceId'],
        ];
    }
}

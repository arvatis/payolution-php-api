<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

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
        return in_array($this->requestType, [RequestTypes::CAPTURE, RequestTypes::RE_AUTH]);
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

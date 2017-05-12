<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class CustomerNumber
 */
class CustomerNumber extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return !in_array($this->requestType, [RequestTypes::CALCULATION, RequestTypes::REFUND, RequestTypes::REVERSAL]);
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_CUSTOMER_NUMBER => $this->data['customer']['customerId']];
    }
}

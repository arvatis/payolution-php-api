<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

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
        return true;
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_CUSTOMER_NUMBER => $this->data['customer']['customerId']];
    }
}

<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class CustomerGroup
 */
class CustomerGroup extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->requestType == RequestTypes::PRE_CHECK || $this->requestType == RequestTypes::PRE_AUTH;
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_CUSTOMER_GROUP => $this->data['customer']['group']];
    }
}

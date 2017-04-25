<?php



namespace Payolution\Request\Transaction\Analysis;

use Payolution\Api\Request\RequestTypes;

/**
 * Class Language
 */
class Language extends CompositeAbstract implements CompositeContract
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
        return [CriterionNames::PAYOLUTION_CUSTOMER_LANGUAGE => $this->data];
    }
}

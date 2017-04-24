<?php



namespace Payolution\Request\Transaction\Analysis;

use Payolution\Api\Request\RequestTypes;

/**
 * Class PreCheck
 */
class PreCheck extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return !$this->previousRequestId && $this->requestType == RequestTypes::PRE_CHECK;
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_PRE_CHECK => 'TRUE'];
    }
}

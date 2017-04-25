<?php



namespace Payolution\Request\Transaction\Analysis;

use Payolution\Request\RequestTypes;

/**
 * Class PreCheckId
 */
class PreCheckId extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->requestType == RequestTypes::PRE_AUTH
            || $this->requestType == RequestTypes::RE_AUTH;
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [
            CriterionNames::PAYOLUTION_PRE_CHECK_ID => $this->previousRequestId,
        ];
    }
}

<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

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
        return $this->requestType == RequestTypes::PRE_AUTH && !isset($this->data['installment']);
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

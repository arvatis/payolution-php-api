<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

class SessionId extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return in_array($this->requestType, [RequestTypes::PRE_CHECK, RequestTypes::PRE_AUTH]);
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_SESSION_ID => $this->data['sessionId']];
    }
}

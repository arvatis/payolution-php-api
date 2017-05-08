<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

class TransactionType extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->isB2BRequest();
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_TRX_TYPE => 'B2B'];
    }
}

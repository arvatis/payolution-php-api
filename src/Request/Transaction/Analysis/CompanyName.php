<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

class CompanyName extends CompositeAbstract implements CompositeContract
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
        return [CriterionNames::PAYOLUTION_COMPANY_NAME => $this->data['billingAddress']['company']];
    }
}

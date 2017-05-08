<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

class CompanyNo extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->isB2BRequest() && !empty($this->data['company']['registration_no']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_COMPANY_NO => $this->data['company']['registration_no']];
    }
}

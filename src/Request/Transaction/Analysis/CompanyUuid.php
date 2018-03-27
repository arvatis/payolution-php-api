<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

class CompanyUuid extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->isB2BRequest() && !empty($this->data['company']['vatId']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [CriterionNames::PAYOLUTION_COMPANY_VAT_ID => $this->data['company']['vatId']];
    }
}

<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

class CompanyType extends CompositeAbstract implements CompositeContract
{
    const COMPANY_TYPE_COMPANY = 'COMPANY';
    const COMPANY_TYPE_SOLE = 'SOLE';
    const COMPANY_TYPE_REGISTERED = 'REGISTERED';
    const COMPANY_TYPE_OTHER = 'OTHER';
    const COMPANY_TYPE_PUBLIC = 'PUBLIC';

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
        $type = $this->getType();
        $data = [CriterionNames::PAYOLUTION_COMPANY_TYPE => $type];
        if ($type != $this::COMPANY_TYPE_SOLE) {
            return $data;
        }
        //TODO: move to own classes
        $data[CriterionNames::PAYOLUTION_COMPANY_OWNER_FAMILY] = $this->data['customer']['lastName'];
        $data[CriterionNames::PAYOLUTION_COMPANY_OWNER_GIVEN] = $this->data['customer']['firstName'];
        $data[CriterionNames::PAYOLUTION_COMPANY_OWNER_BIRTHDATE] = $this->data['customer']['dob'];

        return $data;
    }

    /**
     * @return mixed
     */
    private function getType()
    {
        if (!isset($this->data['company']['type']) ||
            !in_array(
                $this->data['company']['type'],
                [
                    $this::COMPANY_TYPE_COMPANY,
                    $this::COMPANY_TYPE_SOLE,
                    $this::COMPANY_TYPE_REGISTERED,
                    $this::COMPANY_TYPE_OTHER,
                    $this::COMPANY_TYPE_PUBLIC,
                ])
        ) {
            return self::COMPANY_TYPE_COMPANY;
        }

        return $this->data['company']['type'];
    }
}

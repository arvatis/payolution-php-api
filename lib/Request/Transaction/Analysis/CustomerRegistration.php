<?php



namespace Payolution\Request\Transaction\Analysis;

use Payolution\Api\Request\RequestTypes;

/**
 * Class CustomerRegistration
 */
class CustomerRegistration extends CompositeAbstract implements CompositeContract
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
        $customer = $this->data['customer'];
        $registrationDate = $customer['registrationDate'];
        $level = strtotime($registrationDate) > 0 ? 1 : 0;
        $criterionData = [CriterionNames::PAYOLUTION_CUSTOMER_REGISTRATION_LEVEL => $level];
        if ($level) {
            $criterionData[CriterionNames::PAYOLUTION_CUSTOMER_REGISTRATION_DATE] =
                str_replace('-', '', $registrationDate);
        }

        return $criterionData;
    }
}

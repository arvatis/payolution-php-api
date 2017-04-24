<?php



namespace Payolution\Request\Transaction\Analysis;

/**
 * Class Installment
 */
class Installment extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return isset($this->data['installment']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        $installment = $this->data['installment'];

        return [
            CriterionNames::PAYOLUTION_CALCULATION_ID => $installment['calculationId'],
            CriterionNames::PAYOLUTION_INSTALLMENT_AMOUNT => $installment['amount'],
            CriterionNames::PAYOLUTION_DURATION => $installment['durationInMonth'],
        ];
    }
}

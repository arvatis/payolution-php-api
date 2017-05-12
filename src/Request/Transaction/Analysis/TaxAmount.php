<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class TaxAmount
 */
class TaxAmount extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return !in_array(
            $this->requestType,
            [
                RequestTypes::CALCULATION,
                RequestTypes::REVERSAL,
            ]
        );
    }

    /**
     * @return array
     */
    public function collect()
    {
        return [
            CriterionNames::PAYOLUTION_TAX_AMOUNT => $this->getTotalTaxAmount(),
        ];
    }

    /**
     * @return string
     */
    private function getTotalTaxAmount()
    {
        return sprintf('%0.2f', array_sum(array_column($this->data['cartItems'], 'tax')));
    }
}

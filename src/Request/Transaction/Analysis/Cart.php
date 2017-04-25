<?php



namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class Cart
 */
class Cart extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return ($this->requestType == RequestTypes::PRE_CHECK || $this->requestType == RequestTypes::PRE_AUTH)
            && isset($this->data['cartItems']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        $cartItems = $this->data['cartItems'];
        $i = 1;
        $cartCriterionData = [];
        foreach ($cartItems as $cartItem) {
            $cartCriterionData[CriterionNames::PAYOLUTION_ITEM_DESCR . '_' . $i] = $cartItem['name'];
            $cartCriterionData[CriterionNames::PAYOLUTION_ITEM_PRICE . '_' . $i] = $cartItem['price'];
            $cartCriterionData[CriterionNames::PAYOLUTION_ITEM_TAX . '_' . $i] = $cartItem['tax'];
            ++$i;
        }

        return $cartCriterionData;
    }
}

<?php



namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Class Shipping
 */
class Order extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return isset($this->data['order']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        $order = $this->data['order'];

        return [CriterionNames::PAYOLUTION_ORDER_ID => $order['orderId']];
    }
}

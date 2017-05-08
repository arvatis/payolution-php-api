<?php

namespace ArvPayolutionApi\Request\Transaction\Analysis;

/**
 * Class Shipping
 */
class OrderTracking extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return isset($this->data['tracking']);
    }

    /**
     * @return array
     */
    public function collect()
    {
        $tracking = $this->data['tracking'];
        $data = [];

        if (isset($tracking['trackingId'])) {
            $data[CriterionNames::PAYOLUTION_TRANSPORTATION_TRACKING] = $tracking['trackingId'];
        }
        if (isset($tracking['returnTrackingId'])) {
            $data[CriterionNames::PAYOLUTION_TRANSPORTATION_RETURN_TRACKING] = $tracking['returnTrackingId'];
        }
        if (isset($tracking['shippingCompany'])) {
            $data[CriterionNames::PAYOLUTION_TRANSPORTATION_COMPANY] = $tracking['shippingCompany'];
        }

        return $data;
    }
}

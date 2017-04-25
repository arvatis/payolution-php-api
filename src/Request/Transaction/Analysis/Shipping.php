<?php



namespace ArvPayolutionApi\Request\Transaction\Analysis;

use ArvPayolutionApi\Request\RequestTypes;

/**
 * Class Shipping
 */
class Shipping extends CompositeAbstract implements CompositeContract
{
    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->requestType == RequestTypes::PRE_CHECK
            || $this->requestType == RequestTypes::PRE_AUTH
            || $this->requestType == RequestTypes::RE_AUTH;
    }

    /**
     * @return array
     */
    public function collect()
    {
        $shippingAddress = $this->data['shippingAddress'];
        $billingAddress = $this->data['billingAddress'];
        $shippingType = $this->getShippingType($shippingAddress, $billingAddress);

        return [
            CriterionNames::PAYOLUTION_SHIPPING_GIVEN => $shippingAddress['firstName'],
            CriterionNames::PAYOLUTION_SHIPPING_FAMILY => $shippingAddress['lastName'],
            CriterionNames::PAYOLUTION_SHIPPING_COUNTRY => $shippingAddress['countryCode'],
            CriterionNames::PAYOLUTION_SHIPPING_CITY => $shippingAddress['city'],
            CriterionNames::PAYOLUTION_SHIPPING_ZIP => $shippingAddress['postCode'],
            CriterionNames::PAYOLUTION_SHIPPING_STREET => $shippingAddress['street'] . ' '
                . $shippingAddress['houseNumber'],
            CriterionNames::PAYOLUTION_SHIPPING_COMPANY => $shippingAddress['company'],
            CriterionNames::PAYOLUTION_SHIPPING_TYPE => $shippingType,
        ];
    }

    /**
     * @param $shippingAddress
     * @param $billingAddress
     *
     * @return string
     */
    private function getShippingType($shippingAddress, $billingAddress)
    {
        if ($shippingAddress === $billingAddress) {
            return CriterionNames::PAYOLUTION_SHIPPING_TYPE_EQUALS_BILLING_ADDRESS;
        }
        return CriterionNames::PAYOLUTION_SHIPPING_TYPE_ALTERNATIVE_SHIPPING_ADDRESS;
    }
}

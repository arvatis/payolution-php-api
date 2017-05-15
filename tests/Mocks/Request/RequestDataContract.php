<?php

namespace ArvPayolutionApi\Mocks\Request;

/**
 * Class PreCheckData
 */
interface RequestDataContract
{
    /**
     * Request specific credentials
     *
     * @return array
     */
    public function getApiContext();

    /**
     * @return array
     */
    public function getCart();

    /**
     * @return array
     */
    public function getCartItems();

    /**
     * @return array
     */
    public function getShippingAddress();

    /**
     * @return array
     */
    public function getCustomerAddress();

    /**
     * @return array
     */
    public function getCustomer();

    /**
     * @return array
     */
    public function getSytemInfo();
}

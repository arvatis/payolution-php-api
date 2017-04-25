<?php



namespace ArvPayolutionApi\Mocks\Request;

/**
 * Class PreCheckData
 */
abstract class PreCheckDataAbstract implements PreCheckDataContract
{
    /**
      * Request specific credentials
      *
      * @return array
      */
     abstract public function getApiContext();

    /**
     * @return array
     */
    public function getCart()
    {
        return [
            'cartId' => 'Trx 42',
            'currency' => 'EUR',
            'grandTotal' => 249.99,
        ];
    }

    /**
     * @return array
     */
    public function getCartItems()
    {
        return [
            [
                'name' => 'Phone',
                'price' => 349.99,
                'tax' => 49.99,
            ],
            [
                'name' => 'Cover',
                'price' => 9.99,
                'tax' => 0.99,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getShippingAddress()
    {
        return [
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'city' => 'Graz',
            'countryCode' => 'AT',
            'postCode' => '1060',
            'street' => 'Spengergasse',
            'houseNumber' => '38',
            'company' => 'Payolution Company',
        ];
    }

    /**
     * @return array
     */
    public function getCustomerAddress()
    {
        return [
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'city' => 'Wien',
            'countryCode' => 'AT',
            'postCode' => '1050',
            'street' => 'Spengergasse',
            'houseNumber' => '37',
        ];
    }

    /**
     * @return array
     */
    public function getCustomer()
    {
        return [
            'customerId' => 'customerid123456',
            'gender' => 'M',
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'email' => 'max.mustermann@example.com',
            'customerIp' => '192.168.0.1',
            'dob' => '1970-01-30',
            'language' => 'de',
            'registrationDate' => '0000-00-00',
            'group' => 'TOP',
            'phone' => '',
        ];
    }

    /**
     * @return array
     */
    public function getSytemInfo()
    {
        return [
            'vendor' => 'CustomSystemName_ProgrammingLanguage_XML',
            'version' => 'CustomSystemVersion',
            'type' => 'Webshop',
            'url' => 'www.shop.example.com',
            'module' => 'PaymentModuleName',
            'module_version' => 'PaymentModuleVersion',
        ];
    }
}

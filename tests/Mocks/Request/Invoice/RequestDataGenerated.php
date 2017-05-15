<?php

namespace ArvPayolutionApi\Mocks\Request\Invoice;

use ArvPayolutionApi\Helpers\Config;
use ArvPayolutionApi\Mocks\Faker\Providers\CustomerGroup;
use ArvPayolutionApi\Mocks\Faker\Providers\PayolutionCountryCode;
use ArvPayolutionApi\Mocks\Request\RequestDataAbstract;
use ArvPayolutionApi\Mocks\Request\RequestDataContract;
use Faker;

/**
 * Class PreCheckData
 */
class RequestDataGenerated extends RequestDataAbstract implements RequestDataContract
{
    /**
     * @var string
     */
    protected $gender;

    /**
     * @var Faker\Generator|\Faker\Provider\Person|PayolutionCountryCode|CustomerGroup|Faker\Provider\PhoneNumber|Faker\Provider\Internet|\Faker\Provider\de_DE\Person
     */
    protected $faker;

    /**
     * PreCheckData constructor.
     */
    public function __construct()
    {
        $this->faker = Faker\Factory::create('de_DE');
        $this->faker->addProvider(new PayolutionCountryCode($this->faker));
        $this->faker->addProvider(new CustomerGroup($this->faker));
        $this->gender = rand(0, 1) > 0.5 ? 'male' : 'female';
    }

    /**
     * @return array
     */
    public function getApiContext()
    {
        return [
                'mode' => 'CONNECTOR_TEST',
                'transactionId' => 42,
            ] + Config::getPaymentConfig('Invoice', 'PreCheck');
    }

    /**
     * @return array
     */
    public function getCart()
    {
        return [
            'cartId' => $this->faker->uuid,
            'currency' => 'EUR',
            'grandTotal' => 119.,
        ];
    }

    /**
     * @return array
     */
    public function getCartItems()
    {
        return [
            [
                'name' => 'Productname',
                'price' => 119,
                'tax' => 19,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getShippingAddress()
    {
        return [
            'firstName' => $this->faker->firstName($this->gender),
            'lastName' => $this->faker->lastName($this->gender),
            'city' => $this->faker->city,
            'countryCode' => $this->faker->payolutionCountryCode,
            'postCode' => $this->faker->postcode,
            'street' => $this->faker->streetName,
            'houseNumber' => $this->faker->buildingNumber,
            'company' => $this->faker->company,
        ];
    }

    /**
     * @return array
     */
    public function getCustomerAddress()
    {
        return [
            'firstName' => $this->faker->firstName($this->gender),
            'lastName' => $this->faker->lastName($this->gender),
            'city' => $this->faker->city,
            'countryCode' => $this->faker->payolutionCountryCode,
            'postCode' => $this->faker->postcode,
            'street' => $this->faker->streetName,
            'houseNumber' => $this->faker->buildingNumber,
        ];
    }

    /**
     * @return array
     */
    public function getCustomer()
    {
        return [
            'customerId' => $this->faker->uuid,
            'gender' => strtoupper(substr($this->gender, 0, 1)),
            'firstName' => $this->faker->firstName($this->gender),
            'lastName' => $this->faker->lastName($this->gender),
            'email' => $this->faker->email($this->gender),
            'customerIp' => $this->faker->ipv4(),
            'dob' => $this->faker->dateTimeBetween('-100 years', '-10  years')->format('Y-m-d'),
            'language' => 'de',
            'registrationDate' => $this->faker->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'group' => $this->faker->customerGroup(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * @return array
     */
    public function getSytemInfo()
    {
        return [
            'vendor' => 'plentymarkets',
            'version' => '7',
            'type' => 'Webshop',
            'url' => 'arvatis.plentymarkets-cloud01.com',
            'module' => 'plentymarkets Payolution',
            'module_version' => '0.0.1',
        ];
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @see http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'context' => $this->getApiContext(),
            'customer' => $this->getCustomer(),
            'shippingAddress' => $this->getShippingAddress(),
            'billingAddress' => $this->getCustomerAddress(),
            'cart' => $this->getCart(),
            'cartItems' => $this->getCartItems(),
            'systemInfo' => $this->getSytemInfo(),
        ];
    }
}

<?php

namespace ArvPayolutionApi\Request\Transaction\Customer;

/**
 * Class Address
 */
class Address
{
    /**
     * @var  string
     */
    protected $street;
    /**
     * @var  string
     */
    protected $zip;
    /**
     * @var  string
     */
    protected $city;
    /**
     * @var  string
     */
    protected $country;

    /**
     * Address constructor.
     *
     * @param string $street
     * @param string $zip
     * @param string $city
     * @param string $country
     */
    public function __construct($street, $zip, $city, $country)
    {
        $this->street = $street;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}

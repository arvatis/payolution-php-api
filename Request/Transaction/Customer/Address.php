<?php



namespace Payolution\Request\Transaction\Customer;

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
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}

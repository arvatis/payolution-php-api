<?php

namespace ArvPayolutionApi\Request\Transaction\Customer;

/**
 * Class Name
 */
class Name
{
    /**
     * @var  string
     */
    protected $given;
    /**
     * @var  string
     */
    protected $family;
    /**
     * @var  string
     */
    protected $sex;
    /**
     * @var  string
     */
    protected $birthdate;

    /**
     * Name constructor.
     *
     * @param string $given Mandatory
     * @param string $family Mandatory
     * @param string $sex One of [M, F] Optional
     * @param string $birthdate Birthdate in the format yyyy-mm-dd. Mandatory for synchronous and
     */
    public function __construct($given, $family, $sex = '', $birthdate = '')
    {
        $this->given = $given;
        $this->family = $family;
        $this->sex = $sex;
        $this->birthdate = $birthdate;
    }

    /**
     * @return string
     */
    public function getGiven()
    {
        return $this->given;
    }

    /**
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return string
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}

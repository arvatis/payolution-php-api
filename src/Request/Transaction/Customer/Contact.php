<?php



namespace ArvPayolutionApi\Request\Transaction\Customer;

/**
 * Class Contact
 */
class Contact
{
    /**
     * @var  string
     */
    protected $email;
    /**
     * @var  string
     */
    protected $customerIp;

    /**
     * Contact constructor.
     *
     * @param string $email
     * @param string $customerIp
     */
    public function __construct($email, $customerIp)
    {
        $this->email = $email;
        $this->customerIp = $customerIp;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->customerIp;
    }
}

<?php


/**
 * Created by PhpStorm.
 * User: simon
 * Date: 21.12.16
 * Time: 16:53
 */

namespace ArvPayolutionApi\Request\Transaction;

use ArvPayolutionApi\Request\Transaction\Customer\Address;
use ArvPayolutionApi\Request\Transaction\Customer\Contact;
use ArvPayolutionApi\Request\Transaction\Customer\Name;

/**
 * Class Customer
 */
class Customer
{
    /**
     * @var  Contact
     */
    protected $contact;
    /**
     * @var  Address
     */
    protected $address;
    /**
     * @var  Name
     */
    protected $name;

    /**
     * Name constructor.
     *
     * @param Contact $contact
     * @param Address $address
     * @param Name    $name
     */
    public function __construct(Contact $contact, Address $address, Name $name)
    {
        $this->contact = $contact;
        $this->address = $address;
        $this->name = $name;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }
}

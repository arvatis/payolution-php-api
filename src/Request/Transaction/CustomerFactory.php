<?php



namespace ArvPayolutionApi\Request\Transaction;

/**
 * Class CustomerFactory
 */
class CustomerFactory
{
    /**
     * @param array $customer
     * @param array $address
     *
     * @return Customer
     */
    public static function create($customer, $address): Customer
    {
        return new Customer(
            new Customer\Contact($customer['email'], $customer['customerIp']),
            new Customer\Address(
                $address['street'] . ' ' . $address['houseNumber'],
                $address['postCode'],
                $address['city'],
                $address['countryCode']
            ),
            new Customer\Name(
                $customer['firstName'],
                $customer['lastName'],
                isset($customer['gender']) ? $customer['gender'] : '',
                $customer['dob'])
        );
    }
}

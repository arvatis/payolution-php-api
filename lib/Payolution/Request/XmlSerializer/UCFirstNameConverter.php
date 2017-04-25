<?php



namespace Payolution\Request\XmlSerializer;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Class UCFirstNameConverter
 */
class UCFirstNameConverter implements NameConverterInterface
{
    /**
     * Converts a property name to its normalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function normalize($propertyName)
    {
        return ucfirst($propertyName);
    }

    /**
     * Converts a property name to its denormalized value.
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function denormalize($propertyName)
    {
        return lcfirst($propertyName);
    }
}

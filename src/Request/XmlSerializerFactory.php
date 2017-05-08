<?php

namespace ArvPayolutionApi\Request;

use ArvPayolutionApi\Request\XmlSerializer\UCFirstNameConverter;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class XmlSerializerFactory
 */
class XmlSerializerFactory
{
    /**
     * @return XmlSerializer
     */
    public static function create(): XmlSerializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $objectNormalizer = new ObjectNormalizer($classMetadataFactory, new UCFirstNameConverter());
        $serializer = new Serializer([$objectNormalizer], [new XmlEncoder()]);

        return new XmlSerializer($serializer);
    }
}

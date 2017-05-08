<?php

namespace ArvPayolutionApi\Request;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class XmlSerializer
 */
class XmlSerializer
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * SerializerService constructor.
     *
     * @param $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * @param object|array $object
     * @param bool $addXmlVersionNode
     *
     * @return string
     */
    public function serialize($object, $addXmlVersionNode = false)
    {
        $serializedXml = $this->serializer->serialize(
            $object,
            'xml',
            [
                'xml_root_node_name' => is_object($object) ? (new \ReflectionClass($object))->getShortName() : 'Request',
                'xml_format_output' => true,
                'enable_max_depth' => true,
                'use_attributes' => true,
                'xml_encoding' => 'UTF-8',
            ]
        );
        $xml = new \DOMDocument();
        $xml->loadXML($serializedXml);

        $this->removeEmptyTags($xml);

        if ($addXmlVersionNode) {
            return $this->removeBlankLines($xml->saveXML($xml));
        }

        return $this->removeBlankLines($xml->saveXML($xml->documentElement));
    }

    /**
     * @param \DOMDocument $xml
     */
    private function removeEmptyTags(\DOMDocument $xml)
    {
        $xpath = new \DOMXPath($xml);
        while (
            ($nodeList = $xpath->query('//*[not(*) and not(@*) and not(text()[normalize-space()])]'))
            && $nodeList->length
        ) {
            /** @var \DOMNode $node */
            foreach ($nodeList as $node) {
                $node->parentNode->removeChild($node);
            }
        }
    }

    /**
     * @param $xmlString
     *
     * @return string
     */
    private function removeBlankLines($xmlString)
    {
        return '' . preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $xmlString);
    }
}

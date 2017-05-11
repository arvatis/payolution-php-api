<?php

namespace ArvPayolutionApi\Response;

/**
  * Class ResponseAbstract
  */
 class ResponseAbstract implements \JsonSerializable
 {
     /**
     * @return array
     */
    public function jsonSerialize()
    {
        $result = [];

        $class = new \ReflectionClass(get_class($this));
        foreach ($class->getMethods() as $method) {
            if (substr($method->name, 0, 3) == 'get') {
                $propertyName = strtolower(substr($method->name, 3, 1)) . substr($method->name, 4);

                $result[$propertyName] = $method->invoke($this);
            }
        }

        return $result;
    }
 }

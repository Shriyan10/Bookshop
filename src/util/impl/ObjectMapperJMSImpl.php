<?php

namespace App\util\impl;

use App\util\ObjectMapper;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class ObjectMapperJMSImpl implements ObjectMapper
{

    // Create a Serializer instance
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }


    function serialize(mixed $object): string
    {
        // Serialize the object to JSON
        return $this->serializer->serialize($object, 'json');
    }

    function deserialize(string $json, $type): mixed
    {
        return $this->serializer->deserialize($json, $type, 'json');
    }
}
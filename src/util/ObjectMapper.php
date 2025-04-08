<?php

namespace App\util;

interface ObjectMapper
{

    function serialize(mixed $object): string;
    function deserialize(string $json, $type): mixed;

}
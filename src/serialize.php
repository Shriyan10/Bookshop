<?php

// src/SerializeExample.php

require_once 'vendor/autoload.php';

use App\Request\UserCreateRequest;
use JMS\Serializer\SerializerBuilder;

// Create a new instance of the UserCreateRequest object
$userRequest = new UserCreateRequest('John','Doe', 'johndoe@example.com', 12345, 1, 'KTM', 9841111110);

// Create a Serializer instance
$serializer = SerializerBuilder::create()->build();

// Serialize the object to JSON
$jsonContent = $serializer->serialize($userRequest, 'json');

// Output the serialized JSON
echo "Serialized JSON:\n";
echo $jsonContent . "\n";

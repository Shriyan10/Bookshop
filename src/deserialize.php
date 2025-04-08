<?php

// src/DeserializeExample.php

require_once 'vendor/autoload.php';

use App\Request\UserCreateRequest;
use JMS\Serializer\SerializerBuilder;

// Sample JSON to be deserialized
$jsonData = '{"firstName":"John", "lastName":"Doe", "email":"johndoe@example.com","password":12345,"roleId":1,"address":"KTM","contactNo":9841111110 }';

// Create a Serializer instance
$serializer = SerializerBuilder::create()->build();

// Deserialize the JSON string back into a UserCreateRequest object
$userRequestDeserialized = $serializer->deserialize($jsonData, UserCreateRequest::class, 'json');

// Output the deserialized object
echo "\nDeserialized Object:\n";
echo "Name: " . $userRequestDeserialized->getFirstName() . "\n";
echo "Name: " . $userRequestDeserialized->getLastName() . "\n";
echo "Email: " . $userRequestDeserialized->getEmail() . "\n";
echo "Email: " . $userRequestDeserialized->getPassword() . "\n";
echo "Email: " . $userRequestDeserialized->getAddress() . "\n";
echo "Age: " . $userRequestDeserialized->getContactNo() . "\n";
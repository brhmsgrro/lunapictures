<?php
$servername = "hv30svg121";
$database = "lunapict_tienda";
$username = "lunapict";
$password = "Psv@pyimvj78";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>
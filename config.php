<?php

$servername = "localhost";

$database = "u470795851_trabalho";

$username = "u470795851_trabalho";

$password = "#Ewdfh1k7";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());

}

echo "Connected successfully";

mysqli_close($conn);

?>
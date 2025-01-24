<?php

$db_server = 'localhost';
$db_user = 'root';
$db_pass = 'mypassword';
$db_name = 'project1';

// Establishing the connection
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Checking the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "You are connected<br>";

// SQL query
$sql = "INSERT INTO user (name, email) VALUES ('saniyaj2', 'sani2@gmail.com')";

// Execute the query and check for success
if (mysqli_query($conn, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>

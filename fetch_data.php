<?php
// Set up the database connection
$servername = "localhost";
$username = "root"; // Default username for PHPMyAdmin
$password = ""; // No password for localhost
$dbname = "fgls_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);




// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data from the fgls_account table
$sql = "SELECT ID, id_number, name, account_type FROM fgls_account"; // Fetch only the specified columns
$result = $conn->query($sql);

// Create an array to hold the fetched data


$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

// Return the data as JSON
echo json_encode($data);

// Close the connection
$conn->close();
?>

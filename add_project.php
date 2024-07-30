<?php
$conn = new mysqli("localhost", "root", "", "sen");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$link = $_POST['link'];

$sql = "INSERT INTO project (name, link) VALUES ('$name', '$link')";

if ($conn->query($sql) === TRUE) {
    echo "New project created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

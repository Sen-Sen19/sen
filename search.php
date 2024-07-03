<?php
header('Content-Type: application/json; charset=utf-8');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e_learning_live";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(['error' => 'Database connection failed.']);
    exit();
}

// Set character set to utf8
$conn->set_charset("utf8");

// Get search term from POST request
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

// SQL query to search for questions and their answers
$sql = $conn->prepare("
    SELECT q.question_id, q.question, a.answer
    FROM questions q
    LEFT JOIN answer a ON q.question_id = a.question_id
    WHERE q.question LIKE ?
");
$searchTerm = "%$searchTerm%";
$sql->bind_param("s", $searchTerm);

if (!$sql->execute()) {
    http_response_code(500);
    error_log("SQL error: " . $sql->error);
    echo json_encode(['error' => 'Error executing SQL query.']);
    $sql->close();
    $conn->close();
    exit();
}

$result = $sql->get_result();

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

// Return JSON response
echo json_encode($results);

$sql->close();
$conn->close();
?>

<?php

include 'conn.php';


header('Content-Type: application/json');


if ($conn === false) {
    echo json_encode(['success' => false, 'message' => print_r(sqlsrv_errors(), true)]);
    exit; 
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['column_name']) && isset($_POST['table_name'])) {
    $columnName = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['column_name']); // Sanitize column name
    $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['table_name']); // Sanitize table name

    // Log the incoming data for debugging
    error_log("Column Name: $columnName, Table Name: $tableName");

    // SQL command to add a new column to the table
    $sql = "ALTER TABLE [$tableName] ADD [$columnName] NVARCHAR(255)";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => print_r(sqlsrv_errors(), true)]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Column added successfully.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}

// Close the connection
sqlsrv_close($conn);
?>

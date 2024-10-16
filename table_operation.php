<?php

include 'conn.php';

function checkConnection($conn) {
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}


$conn = checkConnection($conn);


$tables = [];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['table_name'])) {
    $tableName = $_POST['table_name'];
    $displayName = $_POST['display_name'];

    
    $sql = "CREATE TABLE [$tableName] (ID INT PRIMARY KEY IDENTITY(1,1))";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

   
    $insertSql = "INSERT INTO created_tables (table_name, display_name) VALUES (?, ?)";
    $insertStmt = sqlsrv_query($conn, $insertSql, array($tableName, $displayName));

    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "<script>alert('Table $tableName created successfully!');</script>";
}


$query = "SELECT table_name, display_name FROM created_tables";
$result = sqlsrv_query($conn, $query);

if ($result !== false) {
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $tables[] = $row;
    }
} else {
    error_log("Error fetching tables: " . print_r(sqlsrv_errors(), true));
}


sqlsrv_close($conn);
?>
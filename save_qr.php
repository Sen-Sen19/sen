<?php
include 'conn.php'; // Include the connection file

// Read the input data
$data = json_decode(file_get_contents('php://input'), true);

// Validate the data
if (isset($data['scanned']) && !empty($data['scanned'])) {
    $scanned = $data['scanned'];

    // Insert the scanned data into the database
    $sql = "INSERT INTO qr (scanned) VALUES (?)";
    $params = array($scanned);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Return error message if query fails
        echo json_encode(['success' => false, 'error' => sqlsrv_errors()]);
    } else {
        // Return success message
        echo json_encode(['success' => true]);
    }
} else {
    // Return error if no data is provided
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}

sqlsrv_close($conn); // Close the database connection
?>

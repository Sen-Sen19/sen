<?php
include 'conn.php';

header('Content-Type: application/json');

try {
    // Retrieve the JSON data
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data)) {
        echo json_encode(['success' => false, 'message' => 'No data to import.']);
        exit;
    }

    // Prepare the SQL insert statement
    $sql = "INSERT INTO [live_mrcs_db].[dbo].[plan_masterlist] (base_product, main_product_no) VALUES (?, ?)";
    $stmt = sqlsrv_prepare($conn, $sql, array(&$base_product, &$main_product));

    if ($stmt === false) {
        throw new Exception(print_r(sqlsrv_errors(), true));
    }

    // Loop through the data and execute insert for each row
    foreach ($data as $row) {
        $base_product = $row['base_product'];
        $main_product = $row['main_product'];
        
        if (!sqlsrv_execute($stmt)) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

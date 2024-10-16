<?php
include 'conn.php'; // Include your connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvFile'])) {
        $file = $_FILES['csvFile']['tmp_name'];

        // Open the CSV file for reading
        if (($handle = fopen($file, 'r')) !== false) {
            fgetcsv($handle); // Skip the first row if it contains column headers

            while (($data = fgetcsv($handle)) !== false) {
                // Prepare SQL statement
                $sql = "INSERT INTO [live_mrcs_db].[dbo].[plan_masterlist] (car_model, main_product_no, car_code, line_no, code, base_no) VALUES (?, ?, ?, ?, ?, ?)";
                $params = array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
                
                // Execute the query
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
            }
            fclose($handle);
            echo "CSV file imported successfully.";
        } else {
            echo "Error opening the CSV file.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>

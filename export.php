<?php
// Include the database connection file
include 'conn.php';

// Include PhpSpreadsheet library
require 'vendor/autoload.php';  // Only if using Composer, else manually include the library

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query to select the top 1000 rows
$sql = "SELECT TOP (1000) [employee_id], [full_name], [username], [department], [password], [role] FROM [my_template_db].[dbo].[account]";
$query = sqlsrv_query($conn, $sql);

if ($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Create new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set header row
$sheet->setCellValue('A1', 'Employee ID');
$sheet->setCellValue('B1', 'Full Name');
$sheet->setCellValue('C1', 'Username');
$sheet->setCellValue('D1', 'Department');
$sheet->setCellValue('E1', 'Password');
$sheet->setCellValue('F1', 'Role');

// Populate spreadsheet with data
$rowNumber = 2;
while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
    $sheet->setCellValue('A' . $rowNumber, $row['employee_id']);
    $sheet->setCellValue('B' . $rowNumber, $row['full_name']);
    $sheet->setCellValue('C' . $rowNumber, $row['username']);
    $sheet->setCellValue('D' . $rowNumber, $row['department']);
    $sheet->setCellValue('E' . $rowNumber, $row['password']);
    $sheet->setCellValue('F' . $rowNumber, $row['role']);
    $rowNumber++;
}

// Write Excel file to output
if (isset($_POST['export'])) {
    $writer = new Xlsx($spreadsheet);
    $filename = "employee_data_" . date('Y-m-d_H-i-s') . ".xlsx";
    
    // Send the file to the browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Employee Data</h1>

    <!-- Table to display data -->
    <table id="employeeTable">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Department</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display the rows
            while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['employee_id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['password']}</td>
                        <td>{$row['role']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Export Button -->
    <form method="post">
        <button type="submit" name="export">Export to Excel</button>
    </form>
</div>

</body>
</html>

<?php

include 'conn.php';

function jsonResponse($success, $message)
{
    header('Content-Type: application/json');
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file']) && isset($_POST['table_name'])) {
    $tableName = $_POST['table_name'];
    $csvFile = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $firstRow = true;
        $columns = [];

        // Fetch the table columns excluding the identity column
        $tableColumnsSql = "SELECT COLUMN_NAME, COLUMNPROPERTY(OBJECT_ID(TABLE_NAME), COLUMN_NAME, 'IsIdentity') AS IsIdentity FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
        $params = [$tableName];
        $columnsResult = sqlsrv_query($conn, $tableColumnsSql, $params);
        if ($columnsResult === false) {
            jsonResponse(false, 'Error fetching table columns: ' . print_r(sqlsrv_errors(), true));
        }

        $columns = [];
        while ($row = sqlsrv_fetch_array($columnsResult, SQLSRV_FETCH_ASSOC)) {
            if ($row['IsIdentity'] != 1) {
                $columns[] = $row['COLUMN_NAME'];
            }
        }

        // Get the first column name (used for uniqueness check)
        $firstColumn = $columns[0];

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

            if ($firstRow) {
                $firstRow = false;
                continue;
            }

            $csvColumnCount = count($data);
            $tableColumnCount = count($columns);

            if ($csvColumnCount != $tableColumnCount) {
                jsonResponse(false, "Mismatch in number of columns. CSV has $csvColumnCount columns, table has $tableColumnCount.");
            }

            // Prepare the values for SQL query
            $values = array_map('quoteValue', $data);

            // Check if the row already exists based on the first column
            $checkSql = "SELECT COUNT(*) AS cnt FROM [$tableName] WHERE " . quoteIdentifier($firstColumn) . " = " . quoteValue($data[0]);
            $checkStmt = sqlsrv_query($conn, $checkSql);
            if ($checkStmt === false) {
                jsonResponse(false, 'Error checking for existing row: ' . print_r(sqlsrv_errors(), true));
            }
            $rowExists = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)['cnt'] > 0;

            if ($rowExists) {
                // Update existing row
                $updateParts = [];
                for ($i = 0; $i < count($columns); $i++) {
                    $updateParts[] = quoteIdentifier($columns[$i]) . " = " . quoteValue($data[$i]);
                }
                $updateSql = "UPDATE [$tableName] SET " . implode(", ", $updateParts) . " WHERE " . quoteIdentifier($firstColumn) . " = " . quoteValue($data[0]);
                $stmt = sqlsrv_query($conn, $updateSql);
                if ($stmt === false) {
                    jsonResponse(false, 'Error updating row: ' . print_r(sqlsrv_errors(), true));
                }
            } else {
                // Insert new row
                $sql = "INSERT INTO [$tableName] (" . implode(",", array_map('quoteIdentifier', $columns)) . ") VALUES (" . implode(",", $values) . ")";
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt === false) {
                    jsonResponse(false, 'Error inserting row: ' . print_r(sqlsrv_errors(), true));
                }
            }
        }
        fclose($handle);
        jsonResponse(true, 'CSV imported/updated successfully into ' . htmlspecialchars($tableName) . '!');
    } else {
        jsonResponse(false, 'Failed to open CSV file.');
    }
}

function quoteIdentifier($value)
{
    return '[' . str_replace(']', ']]', $value) . ']';
}

function quoteValue($value)
{
    return "'" . str_replace("'", "''", $value) . "'";
}

sqlsrv_close($conn);
?>

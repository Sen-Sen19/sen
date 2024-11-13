<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Import</title>
</head>
<body>
    <h2>Import CSV to Database</h2>
    <input type="file" id="csvFileInput" accept=".csv" />
    <button onclick="importCSV()">Import CSV</button>

    <script>
     function importCSV() {
    const fileInput = document.getElementById("csvFileInput").files[0];
    if (!fileInput) {
        alert("Please select a CSV file.");
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const text = e.target.result;
        const rows = text.split("\n").map(row => row.split(","));

        // Filter out any rows that don't have exactly 2 columns
        const data = rows
            .filter(row => row.length >= 2 && row[0].trim() && row[1].trim())
            .map(row => ({
                base_product: row[0].trim(),
                main_product: row[1].trim()
            }));

        if (data.length === 0) {
            alert("No valid data found in the CSV file.");
            return;
        }

        // Send data to PHP using AJAX
        fetch("import_csv.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert("Data imported successfully!");
            } else {
                alert("Data import failed: " + result.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    };

    reader.readAsText(fileInput);
}

    </script>
</body>
</html>

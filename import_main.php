<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import CSV</title>
   <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    padding: 20px;
}

.container {
    max-width: 400px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #218838;
}

input[type="file"] {
    margin-bottom: 10px;
}

   </style>
</head>
<body>
    <div class="container">
        <h1>Import CSV to Database</h1>
        <form id="importForm" method="post" enctype="multipart/form-data" action="import.php">
            <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
            <button type="submit">Import CSV</button>
        </form>
        <div id="message"></div>
    </div>
   <script>
    document.getElementById('importForm').onsubmit = function() {
    const fileInput = document.getElementById('csvFile');
    if (!fileInput.files.length) {
        alert('Please select a CSV file to upload.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
};

   </script>
</body>
</html>

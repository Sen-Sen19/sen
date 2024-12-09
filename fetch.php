<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Data</title>
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Data from Database</h1>
        <table id="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here using JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch data from the PHP file and display it
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('data-table').getElementsByTagName('tbody')[0];
                
                // Loop through the data and add rows to the table
                data.forEach(item => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `<td>${item.id}</td><td>${item.name}</td><td>${item.email}</td>`;
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    </script>

</body>
</html>

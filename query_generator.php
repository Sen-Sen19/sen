<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="styles.css">
   
      
  
</head>

<body>
    <div class="container">
        <h2>Query Generator</h2>
        <form id="queryForm">
            <div class="form-group">
                <label for="operation">Operation:</label>
                <select id="operation" name="operation" required>
                    <option value="">Select an operation</option>
                    <option value="CREATE_DATABASE">Create Database</option>
                    <option value="CREATE_TABLE">Create Table</option>
                    <option value="ADD_COLUMN">Add Column</option>
                    <option value="INSERT">Insert</option>
                    <option value="UPDATE">Update</option>
                    <option value="DELETE">Delete</option>
                    <option value="SELECT">Select</option>
                </select>
            </div>

            <div class="form-group">
                <label for="databaseName">Database Name:</label>
                <input type="text" id="databaseName" name="databaseName" required>
            </div>

            <div class="form-group" id="tableNameGroup">
                <label for="tableName">Table Name:</label>
                <input type="text" id="tableName" name="tableName">
            </div>

            <div class="form-group" id="columnNameGroup">
                <label for="columnName">Column Name:</label>
                <input type="text" id="columnName" name="columnName">
            </div>

            <div class="form-group" id="columnTypeGroup" style="display: none;">
                <label for="columnType">Column Type:</label>
                <select id="columnType" name="columnType">
                    <option value="INT">INT</option>
                    <option value="VARCHAR(255)">VARCHAR(255)</option>
                    <option value="TEXT">TEXT</option>
                    <option value="DATE">DATE</option>
                    <option value="DATETIME">DATETIME</option>
                </select>
            </div>

            <div class="form-group" id="valueGroup">
                <label for="value">Value:</label>
                <input type="text" id="value" name="value">
            </div>

            <div id="selectColumnsGroup" class="form-group" style="display: none;">
                <label for="selectColumns">Select Columns (comma separated):</label>
                <input type="text" id="selectColumns" name="selectColumns">
            </div>

            <div id="whereClause" class="form-group" style="display: none;">
                <label for="whereColumn">Where Clause Column:</label>
                <input type="text" id="whereColumn" name="whereColumn">

                <label for="whereValue">Where Clause Value:</label>
                <input type="text" id="whereValue" name="whereValue">
            </div>

            <button type="button" onclick="generateQuery()">Generate Query</button>
            <button type="button" class="copy-btn" onclick="copyToClipboard()">Copy Query</button>
        </form>

        <h3>Generated SQL Query:</h3>
        <div id="queryOutput"></div>
    </div>
    <script>
        document.getElementById('operation').addEventListener('change', function () {
            var operation = this.value;
            var whereClause = document.getElementById('whereClause');
            var columnNameGroup = document.getElementById('columnNameGroup');
            var columnTypeGroup = document.getElementById('columnTypeGroup');
            var valueGroup = document.getElementById('valueGroup');
            var selectColumnsGroup = document.getElementById('selectColumnsGroup');
            var tableNameGroup = document.getElementById('tableNameGroup');

            if (operation === 'UPDATE' || operation === 'DELETE' || operation === 'SELECT') {
                whereClause.style.display = 'block';
            } else {
                whereClause.style.display = 'none';
            }

            if (operation === 'CREATE_DATABASE') {
                columnNameGroup.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'none';
            } else if (operation === 'CREATE_TABLE') {
                columnNameGroup.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
            } else if (operation === 'ADD_COLUMN') {
                columnNameGroup.style.display = 'block';
                columnTypeGroup.style.display = 'block';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
            } else if (operation === 'DELETE') {
                columnNameGroup.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
            } else if (operation === 'SELECT') {
                columnNameGroup.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'block';
                tableNameGroup.style.display = 'block';
            } else {
                columnNameGroup.style.display = 'block';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'block';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
            }
        });

        function generateQuery() {
            var operation = document.getElementById('operation').value;
            var databaseName = document.getElementById('databaseName').value;
            var tableName = document.getElementById('tableName').value;
            var columnName = document.getElementById('columnName').value;
            var columnType = document.getElementById('columnType').value;
            var value = document.getElementById('value').value;
            var selectColumns = document.getElementById('selectColumns').value;
            var whereColumn = document.getElementById('whereColumn').value;
            var whereValue = document.getElementById('whereValue').value;

            var query = '';

            if (operation === 'CREATE_DATABASE') {
                query = `CREATE DATABASE [${databaseName}]`;
            } else if (operation === 'CREATE_TABLE') {
                query = `CREATE TABLE [${databaseName}].[dbo].[${tableName}] ([id] INT PRIMARY KEY)`;
            } else if (operation === 'ADD_COLUMN') {
                query = `ALTER TABLE [${databaseName}].[dbo].[${tableName}] ADD [${columnName}] ${columnType}`;
            } else if (operation === 'INSERT') {
                query = `INSERT INTO [${databaseName}].[dbo].[${tableName}] ([${columnName}]) VALUES ('${value}')`;
            } else if (operation === 'UPDATE') {
                query = `UPDATE [${databaseName}].[dbo].[${tableName}] SET [${columnName}] = '${value}' WHERE [${whereColumn}] = '${whereValue}'`;
            } else if (operation === 'DELETE') {
                query = `DELETE FROM [${databaseName}].[dbo].[${tableName}] WHERE [${whereColumn}] = '${whereValue}'`;
            } else if (operation === 'SELECT') {
                query = `SELECT ${selectColumns} FROM [${databaseName}].[dbo].[${tableName}] WHERE [${whereColumn}] = '${whereValue}'`;
            }

            document.getElementById('queryOutput').innerText = query;
        }

        function copyToClipboard() {
            var queryOutput = document.getElementById('queryOutput');
            var range = document.createRange();
            range.selectNodeContents(queryOutput);
            var selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand('copy');
            selection.removeAllRanges();
            alert('Query copied to clipboard!');
        }
    </script>
</body>

</html>

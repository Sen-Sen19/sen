<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #282c34;
            color: #61dafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #1c1e22;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            width: 400px;
        }

        h2,
        h3 {
            text-align: center;
            color: #61dafb;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            margin-bottom: 5px;
            color: #61dafb;
        }

        input,
        select,
        button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            box-sizing: border-box;
        }

        input,
        select {
            background-color: #333;
            color: #61dafb;
        }

        button {
            background-color: #20c997;
            color: #fff;
            cursor: pointer;
            margin-top: 20px;
            border: none;
        }

        button:hover {
            background-color: #1ba87a;
        }

        #queryOutput {
            background-color: #333;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 10px;
            color: #61dafb;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .copy-btn {
            background-color: #61dafb;
            color: #282c34;
            margin-top: 10px;
            width: 100%;
        }

        .copy-btn:hover {
            background-color: #1ba87a;
            color: #fff;
        }
    </style>
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
                    <option value="SELECT">Select</option>
                    <option value="INSERT">Insert</option>
                    <option value="UPDATE">Update</option>
                    <option value="DELETE">Delete</option>
                    <option value="LEFT_JOIN">Left Join</option>
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
            
            <div class="form-group" id="columnNameGroup2">
                <label for="columnName2">Column Name2:</label>
                <input type="text" id="columnName2" name="columnName2">
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

            <div id="joinTableGroup" class="form-group" style="display: none;">
                <label for="joinTableName">Join Table:</label>
                <input type="text" id="joinTableName" name="joinTableName">

                <label for="joinValue">Join Value:</label>
                <input type="text" id="joinValue" name="joinValue">

                <label for="joinValue2">Join Value2:</label>
                <input type="text" id="joinValue2" name="joinValue2">
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
            var columnNameGroup2 = document.getElementById('columnNameGroup2');
            var columnTypeGroup = document.getElementById('columnTypeGroup');
            var valueGroup = document.getElementById('valueGroup');
            var selectColumnsGroup = document.getElementById('selectColumnsGroup');
            var tableNameGroup = document.getElementById('tableNameGroup');
            var joinTableGroup = document.getElementById('joinTableGroup');
            
            if (operation === 'UPDATE' || operation === 'DELETE' || operation === 'SELECT' || operation === 'LEFT_JOIN') {
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
                joinTableGroup.style.display = 'none';
            } else if (operation === 'CREATE_TABLE') {
                columnNameGroup.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'ADD_COLUMN') {
                columnNameGroup.style.display = 'block';
                columnNameGroup2.style.display = 'block';
                columnTypeGroup.style.display = 'block';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'INSERT') {
                columnNameGroup.style.display = 'block';
                columnNameGroup2.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'block';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'UPDATE') {
                columnNameGroup.style.display = 'block';
                columnNameGroup2.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'block';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'DELETE') {
                columnNameGroup.style.display = 'none';
                columnNameGroup2.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'SELECT') {
                columnNameGroup.style.display = 'none';
                columnNameGroup2.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'block';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            } else if (operation === 'LEFT_JOIN') {
                whereClause.style.display = 'none';
                columnNameGroup.style.display = 'block';
                columnNameGroup2.style.display = 'block';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'none';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'block';
            } else {
                columnNameGroup.style.display = 'block';
                columnNameGroup2.style.display = 'none';
                columnTypeGroup.style.display = 'none';
                valueGroup.style.display = 'block';
                selectColumnsGroup.style.display = 'none';
                tableNameGroup.style.display = 'block';
                joinTableGroup.style.display = 'none';
            }
        });

        function generateQuery() {
            var operation = document.getElementById('operation').value;
            var databaseName = document.getElementById('databaseName').value;
            var tableName = document.getElementById('tableName').value;
            var columnName = document.getElementById('columnName').value;
            var columnName2 = document.getElementById('columnName2').value;
            var columnType = document.getElementById('columnType').value;
            var value = document.getElementById('value').value;
            var selectColumns = document.getElementById('selectColumns').value;
            var whereColumn = document.getElementById('whereColumn').value;
            var whereValue = document.getElementById('whereValue').value;
            var joinTableName = document.getElementById('joinTableName').value;
            var joinValue = document.getElementById('joinValue').value;
            var joinValue2 = document.getElementById('joinValue2').value;

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
            } else if (operation === 'LEFT_JOIN') {
                query = `SELECT ${tableName}.${columnName}, ${tableName}.${columnName2}, ${joinTableName}.${joinValue} 
                         FROM ${tableName} LEFT JOIN ${joinTableName} ON ${tableName}.${joinValue2} = ${joinTableName}.${joinValue2};`;
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

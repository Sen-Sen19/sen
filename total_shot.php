<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Query Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        h1, h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
        textarea {
            width: 100%;
            height: 200px;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
            font-family: monospace;
            background-color: #fff;
        }
        .copy-btn {
            background-color: #007bff;
        }
        .copy-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SQL Query Generator</h1>
        <label for="inputField">Enter TRD Values (separated by spaces):</label>
        <input type="text" id="inputField" placeholder="e.g. aluminum_visual_inspection aluminum_coating_uv_ii">
        <button onclick="generateQuery()">Generate Query</button>

        <h2>Generated Query:</h2>
        <textarea id="outputField" readonly></textarea>
        <button class="copy-btn" onclick="copyToClipboard()">Copy to Clipboard</button>
    </div>

    <script>
        function generateQuery() {

            const trdValues = document.getElementById('inputField').value.trim().split(/\s+/);
            let queries = [];



trdValues.forEach(trdValue => {
                const sqlQuery = `




                
SELECT 
    CASE 
        WHEN f.[car_model] = 'suzuki old' THEN 'Suzuki Old'
        ELSE 'Other' 
    END AS car_model,
    '${trdValue}' AS process,
    SUM(f.${trdValue} * p.[first_month]) AS first_total_shots,
    SUM(f.${trdValue} * p.[second_month]) AS second_total_shots,
    SUM(f.${trdValue} * p.[third_month]) AS third_total_shots
FROM [live_mrcs_db].[dbo].[first_process] f
JOIN [live_mrcs_db].[dbo].[plan_2] p ON f.[base_product] = p.[base_product]
WHERE f.[car_model] = 'suzuki old'
GROUP BY 
    CASE 
        WHEN f.[car_model] = 'suzuki old' THEN 'Suzuki Old'
        ELSE 'Other' 
    END





   `;

// SELECT 
//         op.[car_model],
//         '${trdValue}' AS process,
//         SUM(op.${trdValue} * p.[first_month]) AS first_total_shots,
//         SUM(op.${trdValue} * p.[second_month]) AS second_total_shots,
//         SUM(op.${trdValue} * p.[third_month]) AS third_total_shots
//     FROM 
//         [live_mrcs_db].[dbo].[other_process] AS op
//     JOIN 
//         (SELECT 
//              [base_product],
//              [first_month],
//              [second_month],
//              [third_month]
//          FROM 
//              [live_mrcs_db].[dbo].[plan_2]
//          ) AS p ON op.[base_product] = p.[base_product]
//     GROUP BY 
//         op.[car_model]



                
                queries.push(sqlQuery.trim());
            });

            const fullQuery = queries.join('\nUNION ALL\n') + '\nUNION ALL';

  
            document.getElementById('outputField').value = fullQuery.trim();
        }

        function copyToClipboard() {
            const outputField = document.getElementById('outputField');
            outputField.select();
            document.execCommand('copy');
            alert('Query copied to clipboard!');
        }
    </script>
</body>
</html>

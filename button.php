<?php
// Include the operations for handling table creation and fetching
include 'table_operation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row" id="buttonContainer">
            <div class="col-md-4">
                <button id="button1" class="btn btn-primary btn-block">Button 1</button>
            </div>
            <div class="col-md-4">
                <button id="button2" class="btn btn-secondary btn-block">Button 2</button>
            </div>
            <div class="col-md-4">
                <button id="button3" class="btn btn-success btn-block">Button 3</button>
            </div>
            <div class="col-md-4 mt-3">
                <button id="addButton" class="btn btn-info btn-block" data-toggle="modal"
                    data-target="#myModal">Add</button>
            </div>
        </div>

        
        <div class="row" id="existingButtons">
            <?php foreach ($tables as $table): ?>
                <div class="col-md-4 mt-3">
                    <button class="btn btn-warning btn-block"
                        onclick="openOptionsModal('<?php echo htmlspecialchars($table['display_name']); ?>', '<?php echo htmlspecialchars($table['table_name']); ?>')">
                        <?php echo htmlspecialchars($table['display_name']); ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Modal for input -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="table_name">Table Name</label>
                            <input type="text" class="form-control" id="table_name" name="table_name" required>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" class="form-control" id="display_name" name="display_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for options -->
    <div class="modal fade" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="optionsModalLabel">Choose an Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button id="importFileBtn" class="btn btn-warning btn-block">Import File</button>
                    <button id="addColumnBtn" class="btn btn-primary btn-block">Add Column</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for importing CSV -->
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCsvModalLabel">Import CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="import_csv.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="table_name" id="import_table_name">
                        <div class="form-group">
                            <label for="csv_file">Choose CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        let selectedTableName = '';

        function openOptionsModal(displayName, tableName) {
            selectedTableName = tableName;
            $('#optionsModal').modal('show');
        }

        document.getElementById('importFileBtn').addEventListener('click', function () {

        });

        document.getElementById('addColumnBtn').addEventListener('click', function () {
            const columnName = prompt('Enter the name for the new column:');
            if (columnName) {
                addColumnToTable(columnName, selectedTableName);
            } else {
                alert('Column name cannot be empty!');
            }
        });

        function addColumnToTable(columnName, tableName) {
            console.log('Attempting to add column:', columnName, 'to table:', tableName);

            if (typeof $ === "undefined") {
                alert('jQuery is not loaded');
                return;
            }

            $.ajax({
                url: 'add_column.php',
                type: 'POST',
                data: {
                    column_name: columnName,
                    table_name: tableName
                },
                success: function (response) {
                    console.log('AJAX response:', response);
                    try {

                        const data = typeof response === 'string' ? JSON.parse(response) : response;

                        if (data.success) {
                            alert('Column added successfully!');
                        } else {
                            alert('Error adding column: ' + data.message);
                        }
                    } catch (e) {
                        alert('Response parsing error: ' + e.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('AJAX error: ' + error);
                }
            });
        }
        document.getElementById('importFileBtn').addEventListener('click', function () {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = '.csv';

            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('csv_file', file);
                    formData.append('table_name', selectedTableName);


                    $.ajax({
                        url: 'import_csv.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('AJAX response:', response);
                            try {
                                const data = typeof response === 'string' ? JSON.parse(response) : response;
                                if (data.success) {
                                    alert('File imported successfully!');
                                } else {
                                    alert('Error importing file: ' + data.message);
                                }
                            } catch (e) {
                                alert('Response parsing error: ' +<?php
// Include the operations for handling table creation and fetching
include 'table_operation.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Table Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <!-- Existing static buttons -->
        <div class="row" id="buttonContainer">
            <div class="col-md-4">
                <button id="button1" class="btn btn-primary btn-block">Button 1</button>
            </div>
            <div class="col-md-4">
                <button id="button2" class="btn btn-secondary btn-block">Button 2</button>
            </div>
            <div class="col-md-4">
                <button id="button3" class="btn btn-success btn-block">Button 3</button>
            </div>
            <div class="col-md-4 mt-3">
                <button id="addButton" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModal">Add</button>
            </div>
        </div>

        <!-- Existing buttons dynamically added from backend -->
        <div class="row mt-3" id="existingButtons">
            <?php foreach ($tables as $table): ?>
                <div class="col-md-4 mt-3">
                    <button class="btn btn-warning btn-block"
                        onclick="openOptionsModal('<?php echo htmlspecialchars($table['display_name']); ?>', '<?php echo htmlspecialchars($table['table_name']); ?>')">
                        <?php echo htmlspecialchars($table['display_name']); ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for adding new table -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addTableForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="table_name">Table Name</label>
                            <input type="text" class="form-control" id="table_name" name="table_name" required>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" class="form-control" id="display_name" name="display_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for options -->
    <div class="modal fade" id="optionsModal" tabindex="-1" role="dialog" aria-labelledby="optionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="optionsModalLabel">Choose an Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button id="importFileBtn" class="btn btn-warning btn-block">Import File</button>
                    <button id="addColumnBtn" class="btn btn-primary btn-block">Add Column</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let selectedTableName = '';

        function openOptionsModal(displayName, tableName) {
            selectedTableName = tableName;
            $('#optionsModal').modal('show');
        }

        // Handling form submission for adding a new table dynamically
        $('#addTableForm').on('submit', function (e) {
            e.preventDefault();

            const tableName = $('#table_name').val();
            const displayName = $('#display_name').val();

            if (tableName && displayName) {
                addButtonToExistingButtons(displayName, tableName);
                $('#myModal').modal('hide'); // Close modal after adding
            }
        });

        // Function to add a new button to the existing buttons dynamically
        function addButtonToExistingButtons(displayName, tableName) {
            const buttonHtml = `
                <div class="col-md-4 mt-3">
                    <button class="btn btn-warning btn-block"
                        onclick="openOptionsModal('${displayName}', '${tableName}')">
                        ${displayName}
                    </button>
                </div>
            `;
            $('#existingButtons').append(buttonHtml);
        }
    </script>

</body>

</html>
 e.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            alert('AJAX error: ' + error);
                        }
                    });
                }
            });

            fileInput.click();
        });

    </script>
</body>

</html>
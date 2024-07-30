<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sen Projects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .projects {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .project {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .project:hover {
            background-color: #333;
            transform: scale(1.05);
        }

        button {
            background-color: #20c997;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        button:hover {
            background-color: #17a589;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #2c2c2c;
            margin: 10% auto;
            padding: 30px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        h2 {
            margin-top: 0;
            color: #20c997;
        }

        label {
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        input[type="text"],
        input[type="url"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #333;
            color: #ffffff;
        }

        input[type="text"]:focus,
        input[type="url"]:focus {
            border-color: #20c997;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- <h1>Sen Projects</h1> -->
        <div class="projects">
            <?php
            $conn = new mysqli("localhost", "root", "", "sen");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT name, link FROM project";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="project" onclick="window.location.href=\'' . $row["link"] . '\'">';
                    echo '<p>' . $row["name"] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No projects found.";
            }
            $conn->close();
            ?>
        </div>
        <button id="addProjectBtn">Add Project</button>
    </div>

    <!-- Add Project Modal -->
    <div id="addProjectModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Project</h2>
            <form id="addProjectForm">
                <label for="projectName">Project Name:</label>
                <input type="text" id="projectName" name="projectName" required>
                <label for="projectLink">Project Link:</label>
                <input type="url" id="projectLink" name="projectLink" required>
                <button type="submit">Add</button>
            </form>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("addProjectModal");
    var btn = document.getElementById("addProjectBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function () {
        modal.style.display = "block";
    }

    span.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.getElementById("addProjectForm").addEventListener("submit", function (event) {
        event.preventDefault();

        var name = document.getElementById("projectName").value;
        var link = document.getElementById("projectLink").value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_project.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                location.reload();
            }
        };

        xhr.send("name=" + name + "&link=" + link);
    });
});

</script>
</body>
</html>

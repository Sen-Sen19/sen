<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .project-square {
            position: relative;
            background-color: #55c455;
            color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .project-square:hover {
            transform: scale(1.05) rotate(-3deg);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            animation: shake 0.3s;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            50% {
                transform: translateX(5px);
            }
            75% {
                transform: translateX(-5px);
            }
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ff5f5f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .close-btn:hover {
            background-color: #ff1f1f;
        }

        .add-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #20c997;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 8px;
        }

        .add-button:hover {
            background-color: #17a2b8;
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
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
        }

        .modal-body input {
            width: calc(100% - 22px); /* Adjust for padding and border */
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Include padding and border in width */
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        #save-button {
            padding: 10px 20px;
            background-color: #20c997;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 8px;
        }

        #save-button:hover {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="project-grid" class="project-grid">
            <!-- Project squares will be added here -->
        </div>
        <button id="add-button" class="add-button">Add Project</button>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Project</h2>
                <span id="close" class="close">&times;</span>
            </div>
            <div class="modal-body">
                <input type="text" id="project-name" placeholder="Enter Project Name">
                <input type="text" id="project-link" placeholder="Enter Project Link">
            </div>
            <div class="modal-footer">
                <button id="save-button">Save</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const addButton = document.getElementById("add-button");
            const modal = document.getElementById("modal");
            const closeModal = document.getElementById("close");
            const saveButton = document.getElementById("save-button");
            const projectNameInput = document.getElementById("project-name");
            const projectLinkInput = document.getElementById("project-link");
            const projectGrid = document.getElementById("project-grid");

            // Load existing projects from localStorage
            const projects = JSON.parse(localStorage.getItem("projects")) || [];
            projects.forEach((project, index) => {
                addProjectSquare(project.name, project.link, index);
            });

            addButton.addEventListener("click", () => {
                modal.style.display = "block";
            });

            closeModal.addEventListener("click", () => {
                modal.style.display = "none";
            });

            saveButton.addEventListener("click", () => {
                const name = projectNameInput.value.trim();
                const link = projectLinkInput.value.trim();
                if (name && link) {
                    const index = projects.length;
                    addProjectSquare(name, link, index);
                    projects.push({ name, link });
                    localStorage.setItem("projects", JSON.stringify(projects));
                    projectNameInput.value = "";
                    projectLinkInput.value = "";
                    modal.style.display = "none";
                }
            });

            window.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });

            function addProjectSquare(name, link, index) {
                const square = document.createElement("div");
                square.className = "project-square";
                square.innerText = name;

                const closeButton = document.createElement("button");
                closeButton.className = "close-btn";
                closeButton.innerText = "X";
                closeButton.addEventListener("click", (event) => {
                    event.stopPropagation();
                    removeProjectSquare(square, index);
                });

                square.appendChild(closeButton);
                square.addEventListener("click", () => {
                    window.location.href = link;
                });

                projectGrid.appendChild(square);
            }

            function removeProjectSquare(square, index) {
                projectGrid.removeChild(square);
                projects.splice(index, 1);
                localStorage.setItem("projects", JSON.stringify(projects));
                refreshProjectGrid();
            }

            function refreshProjectGrid() {
                projectGrid.innerHTML = "";
                projects.forEach((project, index) => {
                    addProjectSquare(project.name, project.link, index);
                });
            }
        });
    </script>
</body>
</html>

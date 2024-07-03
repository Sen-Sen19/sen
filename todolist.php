<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Todo List</title>
<style>
    body {
        background-color: #333;
        color: #fff;
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    .container {
        display: flex;
        gap: 20px;
    }

    .column {
        flex: 1;
     
        padding: 10px;
        border-radius: 8px;
        border: 2px solid #20c997; /* Initial green border */
    }

    .column h2 {
        text-align: center;
    }

    .task-list {
        margin-top: 10px;
    }

    .input-container {
        display: flex;
        margin-top: 10px;
    }

    .input-container input[type="text"] {
        flex: 1;
        padding: 8px;
        font-size: 16px;
        border: none;
        border-radius: 4px 0 0 4px;
        background-color: #9da09f; /* Darker background color */
        color: #fff; /* Text color */
    }

    .input-container button {
        padding: 8px 12px;
        background-color: #20c997; /* Green button */
        color: #fff;
        border: none;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
    }

    .task {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px;
        margin-top: 20px;
        background-color: #555;
        border-radius: 4px;
        width: 420px; /* Fixed width */
        word-wrap: break-word; /* Wrap long words */
    }

    .task .actions {
        display: flex;
        gap: 5px;
    }

    .task span {
        display: block;
        overflow: hidden; /* Hide overflow */
        max-height: 4.5em; /* Limit max height to approximately 3 lines */
        line-height: 1.5em; /* Line height for consistent spacing */
    }

    .task .actions button {
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .task .actions button.check-btn {
        background-color: #4CAF50; /* Green */
        color: white;
    }

    .task .actions button.delete-btn {
        background-color: #f44336; /* Red */
        color: white;
    }

    .task.completed span {
    color: inherit; /* Inherit color from parent */
}

    .container2 {
        display: flex;
        justify-content: center; /* Center align the content */
        align-items: center;
        margin-bottom: 2%;
        border: 2px solid #20c997; /* Green border */
        border-radius: 8px; /* Border radius */
        padding: 10px; /* Padding inside the border */
        color: #fff; /* Font color */
        
    }

    .container2 h2 {
        margin: 0;
    }

    .color-picker-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .color-picker {
        cursor: pointer;
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
    }
</style>
</head>
<body>
<div class="container2">
    <h2 style="margin-left:850px">To-Do List</h2>
    <div class="color-picker-container">
        <input type="color" id="colorPicker" class="color-picker" style="margin-left:800px">
    </div>
</div>

<div class="container">
    <div class="column">
        <h2>Pending</h2>
        <div id="pendingTasks" class="task-list"></div>
        <div class="input-container">
            <input type="text" id="pendingInput" placeholder="Add a pending task...">
            <button onclick="addTask('pending')">Add</button>
        </div>
    </div>
    <div class="column">
        <h2>Revision</h2>
        <div id="revisionTasks" class="task-list"></div>
        <div class="input-container">
            <input type="text" id="revisionInput" placeholder="Add a task for revision...">
            <button onclick="addTask('revision')">Add</button>
        </div>
    </div>
    <div class="column">
        <h2>Plans</h2>
        <div id="plansTasks" class="task-list"></div>
        <div class="input-container">
            <input type="text" id="plansInput" placeholder="Add a plan...">
            <button onclick="addTask('plans')">Add</button>
        </div>
    </div>
    <div class="column completed">
        <h2>Completed</h2>
        <div id="completedTasks" class="task-list"></div>
    </div>
</div>



<script>
// Function to add a new task
function addTask(type) {
    let input, taskListId;

    switch (type) {
        case 'pending':
            input = document.getElementById('pendingInput');
            taskListId = 'pendingTasks';
            break;
        case 'revision':
            input = document.getElementById('revisionInput');
            taskListId = 'revisionTasks';
            break;
        case 'plans':
            input = document.getElementById('plansInput');
            taskListId = 'plansTasks';
            break;
        default:
            return;
    }

    const inputValue = input.value.trim();
    if (inputValue === '') return;

    const task = createTaskElement(inputValue, type);
    document.getElementById(taskListId).appendChild(task);

    // Save tasks to localStorage
    saveTasksToStorage();

    input.value = '';
}

// Function to create a task element
function createTaskElement(taskText, type) {
    const task = document.createElement('div');
    task.className = 'task';

    const span = document.createElement('span');
    span.textContent = taskText;
    task.appendChild(span);

    if (type !== 'completed') {
        const actions = document.createElement('div');
        actions.className = 'actions';

        const checkBtn = document.createElement('button');
        checkBtn.innerHTML = '&#10003;';
        checkBtn.setAttribute('title', 'Mark as Completed');
        checkBtn.className = 'check-btn';
        checkBtn.onclick = function () {
            moveTask(task, 'completedTasks');
        };
        actions.appendChild(checkBtn);

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '&#10005;';
        deleteBtn.setAttribute('title', 'Delete Task');
        deleteBtn.className = 'delete-btn';
        deleteBtn.onclick = function () {
            task.remove();
            saveTasksToStorage(); // Update localStorage on deletion
        };
        actions.appendChild(deleteBtn);

        task.appendChild(actions);
    } else {
        // Create a remove button for completed tasks
        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '&#10003';
        removeBtn.setAttribute('title', 'Remove Task');
        removeBtn.className = 'remove-btn';
        removeBtn.style.backgroundColor = '#4CAF50'; // Set background color
        removeBtn.style.color = 'white'; // Set text color to white

        removeBtn.onclick = function () {
            task.remove();
            saveTasksToStorage(); // Update localStorage on removal
        };
        task.appendChild(removeBtn);
    }

    return task;
}

// Function to move a task to the completed tasks list
function moveTask(task, targetListId) {
    task.querySelector('.actions').remove(); // Remove action buttons
    document.getElementById(targetListId).appendChild(task);
    task.classList.add('completed'); // Apply completed styles
    saveTasksToStorage(); // Update localStorage on task completion
}

// Function to save tasks to localStorage
function saveTasksToStorage() {
    ['pending', 'revision', 'plans', 'completed'].forEach(function (type) {
        const tasks = Array.from(document.getElementById(type + 'Tasks').children)
            .map(function (task) {
                return task.querySelector('span').textContent;
            });
        localStorage.setItem(type + 'Tasks', JSON.stringify(tasks));
    });

    // Save color preference
    const selectedColor = document.getElementById('colorPicker').value;
    localStorage.setItem('selectedColor', selectedColor);
}

// Function to load tasks from localStorage on page load
document.addEventListener('DOMContentLoaded', function () {
    loadTasksFromStorage();
    // Load selected color
    const savedColor = localStorage.getItem('selectedColor');
    if (savedColor) {
        document.getElementById('colorPicker').value = savedColor;
        applyColorPreferences(savedColor);
    }
});

// Function to load tasks from localStorage
function loadTasksFromStorage() {
    ['pending', 'revision', 'plans', 'completed'].forEach(function (type) {
        const tasks = JSON.parse(localStorage.getItem(type + 'Tasks')) || [];
        tasks.forEach(function (taskText) {
            const task = createTaskElement(taskText, type);
            document.getElementById(type + 'Tasks').appendChild(task);
        });
    });
}

// Function to apply color preferences
function applyColorPreferences(color) {
    const columns = document.querySelectorAll('.column');
    columns.forEach(column => {
        column.style.borderColor = color;
    });

    const buttons = document.querySelectorAll('.input-container button');
    buttons.forEach(button => {
        button.style.backgroundColor = color;
    });

    document.querySelector('.container2').style.borderColor = color;

    // Apply color to headers including "To-Do List"
    const headers = document.querySelectorAll('.column h2, .container2 h2');
    headers.forEach(header => {
        header.style.color = color;
    });

    // Apply color to completed tasks' span elements
    const completedTasks = document.querySelectorAll('.task.completed span');
    completedTasks.forEach(task => {
        task.style.color = color;
    });
}

// Handle color changes
document.getElementById('colorPicker').addEventListener('input', function () {
    const selectedColor = this.value;
    applyColorPreferences(selectedColor);
    saveTasksToStorage(); // Save color preference to localStorage
});


</script>
</body>
</html>

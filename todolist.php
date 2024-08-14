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
    border: 2px solid #20c997; 
    background-color: rgba(169, 169, 169, 0.1); 
    opacity: 0.9; 
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
    border: 1px solid black; /* Initial green border */

    border-radius: 4px 0 0 4px;
    background-color: rgba(169, 169, 169, 0.1); /* Semi-transparent gray */
    opacity: 0.9; /* Adjust opacity for glass-like effect */
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
        background-color: rgba(169, 169, 169, 0.1); /* Semi-transparent gray */
        border: 1px solid black; /* Initial green border */
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

/* Modal styles */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Set width to 80% of viewport */
  max-width: 500px; /* Maximum width */
  height: 80%; /* Set height to 80% of viewport */
  max-height: 500px; /* Maximum height */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

/* Close Button */
.close {
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  align-self: flex-end;
  margin-bottom: 10px;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Textarea for notepad */
#notepadTextArea {
  width: 100%;
  height: 80%; /* Adjust as needed */
  margin-top: 10px;
  padding: 10px;
  font-size: 16px;
  resize: none; /* Prevent resizing */
}
.modal-content h2 {
    margin-top: 0;
    margin-bottom: 2px; /* Adjust margin as needed */
}


    
</style>
</head>
<body>
<div class="container2">
<button onclick="openNotepadModal()" title="Open Notepad">
    📝
</button>
    <h2 style="margin-left:810px">To-Do List</h2>
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


<div id="notepadModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>NOTES</h2>
    <textarea id="notepadTextArea" rows="10" style="width: 100%;"></textarea>
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
        // Determine text color for buttons based on background luminance
        const luminance = calculateLuminance(color);
        if (luminance > 0.5) {
            button.style.color = '#333'; // Dark color for light background
        } else {
            button.style.color = '#fff'; // Light color for dark background
        }
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

    // Determine header text color based on background luminance
    const header = document.querySelector('.modal-content h2');
    const luminance = calculateLuminance(color);
    if (luminance > 0.5) {
        header.style.color = '#333'; // Dark color for light background
    } else {
        header.style.color = '#fff'; // Light color for dark background
    }

    // Apply color to modal content background
    const modalContent = document.querySelector('.modal-content');
    modalContent.style.backgroundColor = color;
}

// Calculate luminance of a color
function calculateLuminance(color) {
    const rgb = color.substring(1); // Remove #
    const r = parseInt(rgb.substr(0, 2), 16) / 255;
    const g = parseInt(rgb.substr(2, 2), 16) / 255;
    const b = parseInt(rgb.substr(4, 2), 16) / 255;
    return 0.2126 * r + 0.7152 * g + 0.0722 * b; // Calculate relative luminance
}

// Handle color changes
document.getElementById('colorPicker').addEventListener('input', function () {
    const selectedColor = this.value;
    applyColorPreferences(selectedColor);
    saveTasksToStorage(); // Save color preference to localStorage
});

// Handle color changes
document.getElementById('colorPicker').addEventListener('input', function () {
    const selectedColor = this.value;
    applyColorPreferences(selectedColor);
    saveTasksToStorage(); // Save color preference to localStorage
});



// Function to open the notepad modal
function openNotepadModal() {
    const modal = document.getElementById('notepadModal');
    const notepadTextArea = document.getElementById('notepadTextArea');

    // Load saved content from localStorage
    const savedContent = localStorage.getItem('notepadContent');
    if (savedContent) {
        notepadTextArea.value = savedContent;
    } else {
        notepadTextArea.value = '';
    }

    modal.style.display = 'block';

    // Save content on modal close
    modal.querySelector('.close').onclick = function() {
        modal.style.display = 'none';
        saveNotepadContent(notepadTextArea.value);
    };

    // Prevent modal from closing on click outside the modal content
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'block'; // Ensures modal remains open
        }
    };
}



// Function to close the notepad modal
function closeNotepadModal() {
    const modal = document.getElementById('notepadModal');
    modal.style.display = 'none';
}

// Function to save notepad content to localStorage
function saveNotepadContent(content) {
    localStorage.setItem('notepadContent', content);
}

// Function to load notepad content from localStorage
function loadNotepadContent() {
    const notepadTextArea = document.getElementById('notepadTextArea');
    const savedContent = localStorage.getItem('notepadContent');
    if (savedContent) {
        notepadTextArea.value = savedContent;
    }
}

// Load notepad content on page load
document.addEventListener('DOMContentLoaded', function () {
    loadNotepadContent();
});

</script>
</body>
</html>

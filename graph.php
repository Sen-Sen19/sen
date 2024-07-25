<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dynamic Graph</title>
<style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.graph-container {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  width: 80%;
  max-width: 600px;
}

canvas {
  width: 100%;
  height: 300px;
  border: 1px solid #ddd;
  margin-top: 20px;
}

.controls {
  margin-top: 20px;
}

button {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 4px;
}

button:hover {
  background-color: #0056b3;
}

</style></head>
<body>
  <div class="graph-container">
    <canvas id="myGraph"></canvas> <!-- Canvas element for drawing the graph -->
    <div class="controls">
      <label for="dataInput">Enter Data:</label>
      <input type="text" id="dataInput" placeholder="Enter data points">
      <button onclick="addData()">Add Data</button>
    </div>
  </div>

 <script>
    // Initialize an empty array to store data points
let dataPoints = [];

// Function to add data to the graph
function addData() {
  const inputData = document.getElementById('dataInput').value.trim();
  
  // Validate input
  if (inputData === '') return;
  
  // Convert input to a number (assuming input is numeric)
  const dataValue = parseFloat(inputData);
  
  // Add data point to the array
  dataPoints.push(dataValue);
  
  // Clear input field
  document.getElementById('dataInput').value = '';
  
  // Redraw the graph
  drawGraph();
}

// Function to draw the graph
function drawGraph() {
  const canvas = document.getElementById('myGraph');
  const ctx = canvas.getContext('2d');
  
  // Clear previous drawings
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  // Calculate bar width based on canvas width and number of data points
  const barWidth = canvas.width / dataPoints.length;
  
  // Draw bars for each data point
  ctx.fillStyle = '#007bff'; // Bar color
  dataPoints.forEach((value, index) => {
    const barHeight = value * (canvas.height / 100); // Scale height based on data value
    const x = index * barWidth;
    const y = canvas.height - barHeight;
    ctx.fillRect(x, y, barWidth - 2, barHeight);
  });
}

 </script>
</body>
</html>

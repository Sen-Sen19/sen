<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI-Generated Art Gallery</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #121212;
      color: white;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .gallery {
      max-width: 1000px;
      margin: 0 auto;
    }

    #artContainer {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-top: 20px;
    }

    img {
      width: 100%;
      height: auto;
      border: 2px solid #444;
    }

    button {
      background-color: #20c997;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background-color: #17a589;
    }

  </style>
</head>
<body>
  <div class="gallery">
    <h1>AI-Generated Art Gallery</h1>
    <div id="artContainer"></div>
    <button onclick="generateArt()">Generate New Art</button>
  </div>

  <script>
    let artContainer = document.getElementById('artContainer');

    // Function to fetch AI-generated art (e.g., using an image generation API)
    async function generateArt() {
      artContainer.innerHTML = ''; // Clear previous art

      try {
        // Example of calling an AI art generation API (you can replace this with a specific API endpoint)
        const response = await fetch('https://api.example.com/generate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ prompt: 'beautiful abstract painting' }) // Example prompt
        });
        const data = await response.json();
        
        // Assuming the API returns a URL of the generated image
        const imageUrl = data.image_url; // Adjust according to API response structure

        // Display the image in the artContainer
        const imgElement = document.createElement('img');
        imgElement.src = imageUrl;
        artContainer.appendChild(imgElement);
      } catch (error) {
        console.error('Error fetching AI art:', error);
      }
    }

    // Generate initial art
    generateArt();

  </script>
</body>
</html>

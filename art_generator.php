<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Art Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2d2d2d;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .art-display img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
        }

        .controls button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
            border-radius: 5px;
        }

        .controls button:hover {
            background-color: #45a049;
        }

        .controls input {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            color: black;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>AI Art Generator</h1>
        <div class="controls">
            <input type="text" id="promptInput" placeholder="Enter your art prompt..." />
            <br>
            <button id="nextButton">Next Artwork</button>
            <button id="downloadButton">Download Image</button>
        </div>
        <div class="art-display">
            <img id="artwork" src="" alt="Generated Artwork" />
        </div>
    </div>

<script>
    const nextButton = document.getElementById('nextButton');
    const downloadButton = document.getElementById('downloadButton');
    const artworkImage = document.getElementById('artwork');
    const promptInput = document.getElementById('promptInput');

    async function generateArtwork() {
        const prompt = promptInput.value || "random abstract art"; // Default to "random abstract art" if no input
        const apiKey = 'sk-prod-abcdef1234567890abcdef1234567890'; // Replace with your OpenAI API key

        // API endpoint for DALL·E image generation
        const apiUrl = 'https://api.openai.com/v1/images/generations';

        const response = await fetch(apiUrl, {
            method: 'POST', // Make sure the method is POST
            headers: {
                'Authorization': `Bearer ${apiKey}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                prompt: prompt,
                n: 1,
                size: '1024x1024',
            }),
        });

        if (!response.ok) {
            const error = await response.json();
            console.error('Error:', error);
            return;
        }

        const data = await response.json();
        const imageUrl = data.data[0].url; 

        artworkImage.src = imageUrl;
    }

    function downloadImage() {
        const link = document.createElement('a');
        link.href = artworkImage.src;
        link.download = 'generated-artwork.png';
        link.click();
    }

    nextButton.addEventListener('click', generateArtwork);
    downloadButton.addEventListener('click', downloadImage);
    window.onload = generateArtwork;
</script>

</body>
</html>

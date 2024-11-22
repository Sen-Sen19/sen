<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Image Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            background-color: #20c997;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #17a589;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 20px;
        }

        .message {
            font-size: 14px;
            color: #777;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>AI Image Generator</h1>
        <input type="text" id="textPrompt" placeholder="Enter description here">
        <br>
        <button onclick="generateImage()">Generate Image</button>
        <br><br>
        <img id="outputImage" alt="Generated Image">
        <p class="message" id="message"></p>
    </div>

    <script>
    async function generateImage() {
        const prompt = document.getElementById("textPrompt").value;
        const messageElement = document.getElementById("message");
        const outputImageElement = document.getElementById("outputImage");

        if (!prompt) {
            messageElement.textContent = "Please enter a prompt!";
            return;
        }

        messageElement.textContent = "Generating image... Please wait.";
        outputImageElement.src = "";  // Clear any previous image

        try {
            // Send request to the backend PHP script (ai.php)
            const response = await fetch('ai.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ prompt })
            });

            const contentType = response.headers.get("Content-Type");
            if (contentType && contentType.includes("application/json")) {
                const data = await response.json();

                if (data.images && data.images.length > 0) {
                    const imageUrl = data.images[0];  // Assuming the AI API returns an image URL
                    outputImageElement.src = imageUrl;
                    messageElement.textContent = "Image generated successfully!";
                } else if (data.error) {
                    messageElement.textContent = "Error: " + data.error;
                } else {
                    messageElement.textContent = "No image generated. Please try again.";
                }
            } else {
                messageElement.textContent = "Unexpected response format.";
                console.error("Unexpected response:", await response.text());
            }
        } catch (error) {
            messageElement.textContent = "Error generating image. Please try again later.";
            console.error("Error:", error);
        }
    }
    </script>

</body>
</html>

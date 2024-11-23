<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Sculpting Demo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        body { margin: 0; overflow: hidden; }
        canvas { display: block; }
    </style>
</head>
<body>
    <script>

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

      
        const light = new THREE.PointLight(0xFFFFFF, 1, 100);
        light.position.set(10, 10, 10);
        scene.add(light);

       
        const geometry = new THREE.SphereGeometry(5, 32, 32);
        const material = new THREE.MeshPhongMaterial({ color: 0x0077ff, wireframe: true });
        const sphere = new THREE.Mesh(geometry, material);
        scene.add(sphere);


        camera.position.z = 15;


        let mouseX = 0, mouseY = 0;
        let isSculpting = false;


        window.addEventListener('mousemove', (event) => {
            mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
        });


        window.addEventListener('mousedown', () => isSculpting = true);
        window.addEventListener('mouseup', () => isSculpting = false);

        // Function to manipulate geometry based on mouse movement
        function sculpt() {
            if (isSculpting) {
                const vertices = sphere.geometry.attributes.position.array;
                const radius = sphere.geometry.parameters.radius;

                for (let i = 0; i < vertices.length; i += 3) {
                    const x = vertices[i];
                    const y = vertices[i + 1];
                    const z = vertices[i + 2];

                    // Apply deformation based on mouse position
                    const distance = Math.sqrt(x * x + y * y + z * z);
                    const factor = Math.sin(mouseX * Math.PI) * 0.5; // example interaction based on mouseX

                    // Push and pull vertices in or out
                    vertices[i] += factor * Math.sin(mouseY * Math.PI);  // Sculpt effect along X
                    vertices[i + 1] += factor * Math.cos(mouseX * Math.PI);  // Sculpt effect along Y
                }

                // Inform Three.js that the geometry has changed
                sphere.geometry.attributes.position.needsUpdate = true;
            }
        }

        // Animation loop
        function animate() {
            requestAnimationFrame(animate);

            sculpt(); // Apply sculpting effect

            renderer.render(scene, camera);
        }

        animate();
    </script>
</body>
</html>

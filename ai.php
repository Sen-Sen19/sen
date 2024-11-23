<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draggable Cube with Physics</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        canvas {
            display: block;
        }
    </style>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>
    
    <script>
        // Import Matter.js components
const { Engine, Render, Runner, Bodies, Composite, Mouse, MouseConstraint } = Matter;

// Create the engine and world
const engine = Engine.create();
const world = engine.world;

// Create a renderer
const render = Render.create({
    element: document.body,
    engine: engine,
    options: {
        width: window.innerWidth,
        height: window.innerHeight,
        wireframes: false,
        background: "#fafafa"
    }
});

// Run the renderer and physics engine
Render.run(render);
const runner = Runner.create();
Runner.run(runner, engine);

// Add a draggable cube (with a cubic shape)
const cube = Bodies.rectangle(400, 200, 100, 100, {
    render: {
        fillStyle: "blue",
        strokeStyle: "black",
        lineWidth: 2
    },
    density: 0.04, // Adds a bit of weight to the cube
});
Composite.add(world, cube);

// Add ground
const ground = Bodies.rectangle(window.innerWidth / 2, window.innerHeight - 50, window.innerWidth, 50, {
    isStatic: true,
    render: {
        fillStyle: "green"
    }
});
Composite.add(world, ground);

// Add barriers (walls) to prevent the cube from going off the screen
const leftWall = Bodies.rectangle(0, window.innerHeight / 2, 50, window.innerHeight, { isStatic: true });
const rightWall = Bodies.rectangle(window.innerWidth, window.innerHeight / 2, 50, window.innerHeight, { isStatic: true });
const topWall = Bodies.rectangle(window.innerWidth / 2, 0, window.innerWidth, 50, { isStatic: true });
const bottomWall = Bodies.rectangle(window.innerWidth / 2, window.innerHeight, window.innerWidth, 50, { isStatic: true });

Composite.add(world, [leftWall, rightWall, topWall, bottomWall]);

// Add Mouse Control
const mouse = Mouse.create(render.canvas);
const mouseConstraint = MouseConstraint.create(engine, {
    mouse: mouse,
    constraint: {
        stiffness: 0.2,
        render: {
            visible: false
        }
    }
});
Composite.add(world, mouseConstraint);

// Resize the canvas and ground on window resize
window.addEventListener("resize", () => {
    render.canvas.width = window.innerWidth;
    render.canvas.height = window.innerHeight;

    Matter.Body.setPosition(ground, { x: window.innerWidth / 2, y: window.innerHeight - 50 });
    Matter.Body.setVertices(ground, [
        { x: 0, y: window.innerHeight - 50 },
        { x: window.innerWidth, y: window.innerHeight - 50 },
        { x: window.innerWidth, y: window.innerHeight },
        { x: 0, y: window.innerHeight }
    ]);

    // Update the walls position on resize
    Matter.Body.setPosition(leftWall, { x: 0, y: window.innerHeight / 2 });
    Matter.Body.setPosition(rightWall, { x: window.innerWidth, y: window.innerHeight / 2 });
    Matter.Body.setPosition(topWall, { x: window.innerWidth / 2, y: 0 });
    Matter.Body.setPosition(bottomWall, { x: window.innerWidth / 2, y: window.innerHeight });
});

    </script>
</body>
</html>

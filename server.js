const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server);

app.use(express.static('public'));

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('draw', (data) => {
        socket.broadcast.emit('draw', data);  // Broadcast drawing data to other clients
    });
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});

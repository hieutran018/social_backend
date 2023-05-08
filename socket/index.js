const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server, {
    cors: {
        origin: "http://localhost:3000",
        methods: ["GET", "POST"]
    }
});

// app.get('/', (req, res) => {
//     console.log('server');
// });



server.listen(3001, () => {
    const users = [];
    io.on('connection', (socket) => {
        socket.on('online', (user) => {
            users.push({ displayName: user.displayName, avatar: user.avatar, userId: user.userId, socketId: socket.id });
            socket.broadcast.emit("online", users);
            console.log(users);
        })
        socket.emit("online", users);
        socket.on("disconnect", () => {
            console.log(socket.id);

            socket.broadcast.emit("online", users.pop((user) => user.socketId !== socket.id) ? [] : users.pop((user) => user.socketId !== socket.id));
            console.log(users.pop((user) => user.socketId !== socket.id));
        });

    });
});
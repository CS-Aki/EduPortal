const express = require("express");
const socketio = require("socket.io");

const app = express();

// Serve static files (only needed if hosting frontend with backend)
app.use(express.static("eduportal"));

// Dynamic port configuration
const PORT = process.env.PORT || 4000; // Use PORT from Render or fallback to 4000 locally
const expressServer = app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});

// Configure Socket.IO with CORS
const io = socketio(expressServer, {
    cors: {
        origin: process.env.FRONTEND_URL || "http://localhost:4000", // Set your frontend URL
        methods: ["GET", "POST"]
    }
});

// Socket.IO event handling
io.on("connection", (socket) => {
    console.log("A user connected");

    // Listen for new comments
    socket.on("serverRcvComment", (data) => {
        console.log("Received new comment:", data);
        console.log("ID " . data.postId);
        // Broadcast new comment to all connected clients
        io.emit(data.postId, data);
    });

    socket.on("disconnect", () => {
        console.log("A user disconnected");
    });

    socket.on("serverRcvPost", (data)=>{
        console.log("Receive new post ", data);
        io.emit("displayNewPost", data);
    });
    
});

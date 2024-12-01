$(document).ready(function() {
  
  console.log(io);

  const socket = io("https://eduportal-wgrc.onrender.com", {
    transports: ["websocket"] // Ensure WebSocket transport
  });

  socket.on('connect_error', (err) => {
      console.error("Connection error:", err);
  });

  socket.on('connect', () => {
    console.log('Connected to Socket.IO server');
  });

  socket.on('displayNewComment', data=>{
    console.log("this is the ", data);
    
    $('#comments').append("<div class='d-flex align-content-center mb-3' id='comment-container'><div class='me-lg-3 d-flex align-items-center justify-content-center'> <img src='"+data.image+"' style='width: 35px;' class='rounded-5'></span></div><div class=''><div class='d-flex'><p class='green2 fw-semibold lh-sm m-0 p-0 ' id='comment-name'>"+ data.name + "</p><p class='black3 fw-semibold lh-sm ms-2 m-0 p-0 fs-6' id='comment-date'>"+ data.month +" "+ data.day +"</p></div><div class='m-0 p-'><p class='black2 m-0 p-0' id='comment'>" + data.comment + "</p></div></div></div>");

  });

  });
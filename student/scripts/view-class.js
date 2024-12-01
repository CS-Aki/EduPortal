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

  socket.on('displayNewPost', data=>{
    console.log("this is the ", data);
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    let temp = data.date.charAt(5) + data.date.charAt(6);
    let month = months[temp - 1];
    let day = data.date.charAt(8) + data.date.charAt(9);
    let year = data.date.charAt(0) + data.date.charAt(1) + data.date.charAt(2) + data.date.charAt(3);

    switch(data.contentType){
      case "material":

        $('#materialContent').append("<a href='material.php?class="+data.classCode+"&post="+ md5(data.title) +"'<div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'><p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>"+ data.title +"<br><span class='fs-6 fw-light green3' id='material-date'>"+ month +" "+ day +", "+ year +"</span></p></div></div></a>");
        // $('#materialContent').append("<div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'>");
        // $('#materialContent').append("<div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div>");
        // $('#materialContent').append("<div class='ms-3 mt-1'>");
        // $('#materialContent').append("<p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>"+ data.title +"<br>");
        // $('#materialContent').append("<span class='fs-6 fw-light green3' id='material-date'>"+ month +" "+ day +", "+ year +"</span></p></div></div></a>");

        break;

      case "activity":
        $('#actsContent').append("<a href='material.php?class="+data.classCode+"&post="+ md5(data.title) +"'<div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'><p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>"+ data.title +"<br><span class='fs-6 fw-light green3' id='material-date'>"+ month +" "+ day +", "+ year +"</span></p></div></div></a>");

        break; 

      case "quiz":
        $('#quizContent').append("<a href='material.php?class="+data.classCode+"&post="+ md5(data.title) +"'<div class='container-fluid bg-body-tertiary d-flex align-content-center rounded-3 px-4 py-2 mb-2 shadow-elevation-dark-1'><div><i class='bi bi-bookmark-fill green1 fs-2 p-0 m-0'></i></div><div class='ms-3 mt-1'><p class='green2 fw-bold lh-1 fs-5 mb-0 pb-0' id='material-title'>"+ data.title +"<br><span class='fs-6 fw-light green3' id='material-date'>"+ month +" "+ day +", "+ year +"</span></p></div></div></a>");

        break; 
    }
    // $('#comments').append("<div class='d-flex align-content-center mb-3' id='comment-container'><div class='me-lg-3 d-flex align-items-center justify-content-center'> <img src='"+data.image+"' style='width: 35px;' class='rounded-5'></span></div><div class=''><div class='d-flex'><p class='green2 fw-semibold lh-sm m-0 p-0 ' id='comment-name'>"+ data.name + "</p><p class='black3 fw-semibold lh-sm ms-2 m-0 p-0 fs-6' id='comment-date'>"+ data.month +" "+ data.day +"</p></div><div class='m-0 p-'><p class='black2 m-0 p-0' id='comment'>" + data.comment + "</p></div></div></div>");

  });

  });
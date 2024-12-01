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

      displayComments();

      $('.comment-btn').click(function(e) {
        e.preventDefault();
        // var class_code = $(this).closest('div').find('.class-code').text();
        // console.log(class_code);
        var comment = $(this).closest('div').find('#commentArea').val();
        // console.log(comment);
        // console.log("clicked");

        let searchParams = new URLSearchParams(window.location.search);
        let classUrl = searchParams.get('class');
        let postUrl = searchParams.get('post');
        
        $.ajax({
          method: "POST",
          url: "student%20backend/includes/comment.php",
          data: {
            'comment': comment,
            'class-code': classUrl,
            'post-title': postUrl
          },

          success: function(response) {
            // console.log(response);

            if (response.includes("Success Comment")) {
                // console.log("inside");
                $.ajax({
                    method: "GET",
                    url: "student%20backend/includes/view-post.php",
                    data: {
                      'post': postUrl,
                      'temp' : "temp",
                      'code' : classUrl
                    },
                  
                    success: function(response) {
                      const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                      let temp =  response[response.length - 1]["month"].charAt(5) +  response[response.length - 1]["month"].charAt(6);
                      let month = months[temp - 1];
                      month = month[0] + "" + month[1] + "" + month[2];
                      let day = response[response.length - 1]["month"].charAt(8) + response[response.length - 1]["month"].charAt(9);

                      // console.table(response);
                      let comment =  response[response.length - 1]["comment"];
                      comment = comment.replaceAll("\n", "<br>");
                    //   console.log("This is the " + response[response.length - 1]["comment"]);
                    //   $('#appendNewComment').text(response[response.length - 1]["comment"]);
                      
                      // $('#comments').append("<div class='d-flex align-content-center mb-3' id='comment-container'><div class='me-lg-3 d-flex align-items-center justify-content-center'> <img src='"+response[response.length - 1]["image"]+"' style='width: 35px;' class='rounded-5'></span></div><div class=''><div class='d-flex'><p class='green2 fw-semibold lh-sm m-0 p-0 ' id='comment-name'>"+ response[response.length - 1]["name"] + "</p><p class='black3 fw-semibold lh-sm ms-2 m-0 p-0 fs-6' id='comment-date'>"+ month +" "+ day +"</p></div><div class='m-0 p-'><p class='black2 m-0 p-0' id='comment'>" + comment + "</p></div></div></div>");
                      // // $('#appendNewComment').removeAttr('id');
                      $('#commentArea').val("");

                      var data = {
                          image : response[response.length - 1]["image"],
                          comment : comment,
                          name : response[response.length - 1]["name"],
                          id : response[response.length - 1]["user_id"],
                          month : month,
                          day : day
                      };
                      // console.log("DATA "+ data);
                      // conn.send(JSON.stringify(data));
                      socket.emit("serverRcvComment", data);
                      
                    },
                    error: function(xhr, status, error) {
                      console.log("Status "+ status + " An error occured" + error)
                    }
                  });
            }

          },
          error: function(xhr, status, error) {
            console.log("Status "+ status + " An error occured" + error)
          }
        });

      });

      function displayComments(){
        let searchParams = new URLSearchParams(window.location.search);
        let classUrl = searchParams.get('class');
        let postUrl = searchParams.get('post');
        
        $.ajax({
          method: "GET",
          url: "student%20backend/includes/view-post.php",
          data: {
            'post': postUrl,
            'temp' : "temp",
            'code' : classUrl
          },
        
          success: function(response) {
            if(response == null) return;
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let temp =  response[response.length - 1]["month"].charAt(5) +  response[response.length - 1]["month"].charAt(6);
            let month = months[temp - 1];
            month = month[0] + "" + month[1] + "" + month[2];
            let day = response[response.length - 1]["month"].charAt(8) + response[response.length - 1]["month"].charAt(9);
            // console.table(response);

            $.each(response, function (key, value) {
              // console.table(value);
              // console.log(value)
              let temp =  value["month"].charAt(5) +  value["month"].charAt(6);
              let month = months[temp - 1];
              // console.log(month);
              month = month.charAt(0) + "" + month.charAt(1) + "" + month.charAt(2);

              let day = value["month"].charAt(8) + value["month"].charAt(9);
              let comment =  value["comment"];
              comment = comment.replaceAll("\n", "<br>");  
              $('#comments').append("<div class='d-flex align-content-center mb-3' id='comment-container'><div class='me-lg-3 d-flex align-items-center justify-content-center'> <img src='"+value["image"]+"' style='width: 35px;' class='rounded-5'></span></div><div class=''><div class='d-flex'><p class='green2 fw-semibold lh-sm m-0 p-0 ' id='comment-name'>"+ value["name"] + "</p><p class='black3 fw-semibold lh-sm ms-2 m-0 p-0 fs-6' id='comment-date'>"+ month +" "+ day +"</p></div><div class='m-0 p-'><p class='black2 m-0 p-0' id='comment'>" + comment + "</p></div></div></div>");
            });

            $('#commentArea').val("");
          },
          error: function(xhr, status, error) {
            console.log("Status "+ status + " An error occured" + error)
          }
        });
      }

});
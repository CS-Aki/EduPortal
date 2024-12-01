
  
        $(document).on('submit', '#changeProfileForm', function (e) {
                e.preventDefault();

                $('#file').click();

                $('#file').one('change', function () {
                    const file = this.files[0];
                    const fileType = file ? file.type : null;
                    const fileSize = file ? file.size : 0;
                    const match = ['image/jpeg', 'image/jpg', 'image/png'];

                    if (!file) {
                        // alert("No file selected.");
                        return false;
                    }

                    if (!(fileType === match[0] || fileType === match[1] || fileType === match[2])) {
                        alert("Invalid File Type. Only accepts JPEG/JPG/PNG");
                        $("#file").val(''); 
                        return false;
                    }

                    if (fileSize > 5000000) {
                        alert("Exceeded file size (Max: 5MB)");
                        $("#file").val('');
                        return false;
                    }

                    console.log(`File selected: ${file.name}`);

                    const formData = new FormData($("#changeProfileForm")[0]);
                    console.log(formData);
                    $.ajax({
                        url: "includes/change-profile.php",
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            var date = new Date();
                            console.log("Upload successful:", response);
    
                            $("#imageProfile").attr("src", "../profiles/" + response +"?t=" + date.getTime()); 
                            $("#smolImg").attr("src", "../profiles/" + response +"?t=" + date.getTime()); 
                        },
                        error: function (xhr, status, error) {
                            console.log("Error:", status, error);
                        },
                    });
                });
        });
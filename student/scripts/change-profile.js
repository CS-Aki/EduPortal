$(document).on('submit', '#changeProfileForm', function (e) {
    e.preventDefault();

    $('#file').click(); 

    $('#file').one('change', function () {
        const file = this.files[0];
        const fileType = file ? file.type : null;
        const fileSize = file ? file.size : 0;
        const match = ['image/jpeg', 'image/jpg', 'image/png'];

        if (!file) {
            Swal.fire({
                icon: 'warning',
                title: 'No File Selected',
                text: 'Please select a file before proceeding.',
            });
            return false;
        }

        if (!(fileType === match[0] || fileType === match[1] || fileType === match[2])) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'Only JPEG, JPG, or PNG files are allowed.',
            });
            $("#file").val('');
            return false;
        }

        if (fileSize > 5000000) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'The maximum allowed file size is 5MB.',
            });
            $("#file").val('');
            return false;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            $("#imageProfile").attr("src", e.target.result);
            $("#smolImg").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);

        $('#save-changes').prop('disabled', false);

        $('#save-changes').one('click', function () {
            const formData = new FormData($("#changeProfileForm")[0]);
            
            $.ajax({
                url: "student backend/change-profile.php",
                type: "POST",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    var date = new Date();
                    console.log("Upload successful:", response);

                    $("#imageProfile").attr("src", "../profiles/" + response + "?t=" + date.getTime());
                    $("#smolImg").attr("src", "../profiles/" + response + "?t=" + date.getTime());

                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated',
                        text: 'Your profile image has been successfully updated.',
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: 'Something went wrong while uploading your image. Please try again.',
                    });
                },
            });
        });
    });
});

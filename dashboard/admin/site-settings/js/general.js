$(document).ready(function() {
    $("#index-image-description").on("input", function() {
        console.log($(this).val());
        if ($(this).val()) {
            $("#submit-index-image-description").removeAttr("disabled");
        } else {
            $("#submit-index-image-description").attr("disabled","disabled");
        }
    });

    $("#upload-index-image").on("change", function(e){
        var files = $("#upload-index-image").prop("files");
        if (files.length > 0) { // Checking if there's selected files
            // indexImagePreview(this); // Load images preview
            $("#upload-index-name").html(files.length+" fichero seleccionado."); // Updating input text.
            $("#submit-index-image").removeAttr("disabled");
        } else {
            // If no files are selected, reset form.
            $("#upload-index-name").html("Seleccionar fichero...");
            $("#submit-index-image").attr("disabled","disabled");
        }
    });

    $("#submit-index-image-description").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("index-image-description", $("#index-image-description").val()); // encoding string to pass it to php file
        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/site-settings/update_index_image_description.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=general-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });

    $("#submit-index-image").on("click", function(e){
        // Getting data to sent and appending it to the form data.
        var formData = new FormData();

        formData.append("filename", "index.php"); // encoding string to pass it to php file

        // getting files metadata to pass it to php file
        var files = $("#upload-index-image").prop("files");
            for (var i = 0; i < files.length; i++) {
                formData.append("image"+i, files[i]);
            }

        // Sending AJAX request to the server.
        $.ajax({
            url: './admin/site-settings/update_index_image.php', // this is the target
            type: 'post', // method
            dataType: 'text', // what is expected to be returned
            cache: false,
            data: formData, // pass the input valuse to serve
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            success: function(response) { // HTTP response code is 200
                alert(response);
                window.location.replace("?page=general-settings"); // redirect
            },
            error: function(response) { // HTTP response code is != than 200
                alert(response);
            }
        });
    });
})
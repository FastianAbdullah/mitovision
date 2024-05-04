<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Add Bootstrap CSS link if not already included -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="Upload-Exceed-Dialog" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalLongTitle">Count Exceeded!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <p>User Your Image Upload Count has exceeded.Please Upgrade your plan.</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="GoToPlansButton" data-dismiss="modal">Go To Plans</button>
            </div>
        </div>
        </div>
    </div>
    <div class="container mt-5" id="upload">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Static Image -->
                <img src="images/detector.jpg" class="img-fluid rounded" alt="Static Image"
                    style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>

            <!-- Right Column -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <!-- Enhanced Dotted Box -->
                <div
                    style="border: 3.4px dotted #01060a; padding: 20px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0); height: 100%; width: 100%;">
                    <!-- Upload Image Form -->
                    <form enctype="multipart/form-data" id="upload-form">
                        <!-- CSRF token -->
                        @csrf
                        <!-- First Row: Patient ID and Patient Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="patientPhone" class="form-label">Patient Phone Number<span class="text-danger">  *</span></label>
                                <input type="text" class="form-control" id="patientPhone" name="patient_phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="patientName" class="form-label">Patient Name</label>
                                <input type="text" class="form-control" id="patientName" name="patient_name">
                            </div>
                        </div>
                        <!-- Second Row: Gender and Blood Group -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="gender" name="gender">
                            </div>
                            <div class="col-md-4">
                                <label for="bloodGroup" class="form-label">Blood Group</label>
                                <input type="text" class="form-control" id="bloodGroup" name="blood_group">
                            </div>
                            <div class="col-md-4">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                        </div>
                        <!-- Upload Image Button -->
                        <div class="mb-3 d-flex align-items-center justify-content-center">
                            <input type="file" class="form-control" id="imageUpload" name="image"
                                style="display:none;">
                            <button type="button" class="btn btn-secondary" id="selectImageButton">Select
                                Image</button>
                        </div>
                        <!-- Display Uploaded Image Name -->
                        <div id="imageNameDisplay" class="mb-3" style="display:none;">
                            <strong>Uploaded Image:</strong> <span id="imageName"></span>
                        </div>
                        <!-- Get Prediction Button -->
                        <button type="submit" class="btn btn-primary" id="getPredictionButton">Get
                            Prediction</button>
                        <br><br>
                        <div class="d-flex justify-content-center">
                            <div id="loader" class="test-loader spinner-border d-none"
                                style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </form>
                    <!-- Prediction Outputs -->
                    <div id="predictionOutputs" class="mt-3"></div>
                    <!-- Prediction Result -->
                    <div id="predictionResult" class="mt-3"></div>
                    <!-- Error Messages -->
                    <div id="errorMessages" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
    <a href="#services" id="servicesAnchor" style="display:none;"></a>
    <!-- Add jQuery library -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Bind event listener to Get Prediction button
            $('#upload-form').on('submit', function(event) {

                event.preventDefault(); // Prevent default form submission
                checkLoginAndUpload(); // Call function to check login and upload image
            });

            $('#GoToPlansButton').on('click',function(){
                GoToServices();
            });
            // Bind event listener to Select Image button
            $('#selectImageButton').on('click', function() {
                clearPreviousResults();
                checkLoginBeforeSelectingImage(); // Call function to check login before selecting image
            });

            // Handle file input change event
            $('#imageUpload').on('change', function() {
                clearPreviousResults();
                // Check if file is selected
                if (this.files && this.files[0]) {
                    // Display selected file name
                    $('#imageName').text(this.files[0].name);
                    $('#imageNameDisplay').show(); // Show image name display
                    // $('#getPredictionButton').prop('disabled', false); // Enable Get Prediction button
                }
            });
        });

        function GoToServices(){
            document.getElementById('servicesAnchor').click();
        }
        function checkLoginBeforeSelectingImage() {
            // Simulate login checking here if needed
            @guest
            // Navigate to services section if not logged in
            document.getElementById('servicesAnchor').click();
        @else
            // If logged in, allow selecting image
            $('#imageUpload').click(); // Trigger click on file input
        @endguest
        }

        function checkLoginAndUpload() {
            // Simulate login checking here if needed
            @guest
            // Navigate to services section
            document.getElementById('servicesAnchor').click();
        @else
            check_limit_and_upload();
        @endguest
        }

        function check_limit_and_upload(){
            $.ajax({
                url:'/check-limit',
                type: 'GET',
                contentType:false,
                processData:false,
                success: function(response){
                    // true response means limit crossed and vice versa.
                    if(response.limit_cross == false){
                        showLoader(); // Show the loader
                        setTimeout(function() {
                            uploadImage(); // Call function to upload image after 3 seconds
                        },10);
                    }
                    else{
                        //Do pop-ups if limit exceeded.
                        open_dialog_box();
                        //alert('User Your Image Upload Count has exceeded!');
                    }
                },
                error: function(xhr,textstatus,errorThrown){
                    //alert error msg if occured.
                    alert('Error Occured while retriving Response');
                }
            });
        }

        function open_dialog_box(){
            $('#Upload-Exceed-Dialog').modal('show');
        }

        function uploadImage() {
            var formData = new FormData($('#upload-form')[0]); // Get form data
            formData.append('_token', '{{ csrf_token() }}'); // Append CSRF token

            $.ajax({
                url: '/upload-image', // Form action URL
                type: 'POST',
                data: formData, // Form data
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle success response
                    // Clear previous results and errors
                    $('#predictionOutputs').empty();
                    $('#predictionResult').empty();
                    $('#errorMessages').empty();

                    if (response.outputs) {
                        var total = response.outputs.reduce((acc, val) => acc + val, 0);
                        var categories = Object.keys(response.outputs);
                        var percentages = Object.values(response.outputs);

                        var outputHtml =
                            '<div class="mt-3"><strong>Output:</strong><div class="bar-container">';
                        for (var i = 0; i < categories.length; i++) {
                            var category = categories[i];
                            var percentage = percentages[i];
                            var width = (percentage / total) * 200;
                            var color = category == 0 ? '#ff6347' : (category == 1 ? '#98fb98' : '#007BFF');

                            outputHtml += '<div class="bar-item">';
                            outputHtml += '<div class="bar-label" style="position: absolute; left: 170px;">';
                            outputHtml += category == 0 ? 'Mitosis' : (category == 1 ? 'Normal' : category);
                            outputHtml += '</div>';
                            outputHtml += '<div class="bar" style="width: ' + width +
                                '%; margin-bottom: 10px; height: 20px; background-color: ' + color +
                                '; margin-right: 10px; border-radius: 2px; transition: width 0.3s ease-in-out;">';
                            outputHtml +=
                                '<div class="bar-percentage" style="font-size: 14px; color: #000000; position: absolute; right: 170px;">';
                            outputHtml += Math.round(percentage * 100) + '%</div><br><br></div></div>';
                        }
                        outputHtml += '</div></div>';
                        $("#loader").addClass("d-none");
                        $('#predictionOutputs').html(outputHtml);
                    }

                    if (response.result) {
                        var resultHtml =
                            '<div class="alert alert-info mt-3"><strong>Result:</strong> This image is highly likely to be <strong>' +
                            response.result + '</strong>.</div>';
                        $('#predictionResult').html(resultHtml);
                        $("#loader").addClass("d-none");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle error response
                    var errors = xhr.responseJSON.errors; // Get error messages
                    var errorMessage =
                        '<div class="alert alert-danger mt-3"><ul style="text-align: left;">'; // Construct error message list
                    $.each(errors, function(key, value) {
                        errorMessage += '<li>' + value + '</li>'; // Add each error message to list
                    });
                    errorMessage += '</ul></div>'; // Close error message list
                    $('#errorMessages').html(errorMessage); // Display error messages
                    $("#loader").addClass("d-none");
                }
            });
        }

        function showLoader() {
            $("#loader").removeClass("d-none");
        }

        // Function to hide loader
        function hideLoader() {
            $('#loader').hide();
        }
        function clearPreviousResults() {
        $('#predictionOutputs').empty(); // Clear prediction outputs
        $('#predictionResult').empty(); // Clear prediction result
        $('#errorMessages').empty(); // Clear error messages
    }
    </script>

</body>

</html>
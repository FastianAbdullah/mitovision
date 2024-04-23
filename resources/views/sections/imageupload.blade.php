<div class="container mt-5">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Static Image -->
            <img src="images/detector.jpg" class="img-fluid rounded" alt="Static Image" 
                 style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease-in-out;"
                 onmouseover="this.style.transform='scale(1.05)'" 
                 onmouseout="this.style.transform='scale(1)'">
        </div>

        <!-- Right Column -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <!-- Enhanced Dotted Box -->
            <div style="border: 3.4px dotted #01060a; padding: 20px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0); height: 100%; width: 100%;">
                <!-- Upload Image Form -->
                <form action="/upload-image" method="post" enctype="multipart/form-data" id="upload-form">
                    @csrf <!-- CSRF token -->
                    
                    <!-- Upload Image Button -->
                    <div class="mb-3">
                        <label for="imageUpload" class="form-label">Upload Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="imageUpload" name="image" style="display:none;" required onchange="displayImageName()">
                            <button type="button" class="btn btn-secondary" onclick="checkLoginAndUpload()">Select Image</button>
                        </div>
                    </div>

                    <!-- Display Uploaded Image Name -->
                    <div id="imageNameDisplay" class="mb-3" style="display:none;">
                        <strong>Uploaded Image:</strong> <span id="imageName"></span>
                    </div>

                    <!-- Get Prediction Button -->
                    <button type="submit" class="btn btn-primary">Get Prediction</button>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="#services" id="servicesAnchor" style="display:none;"></a>

<script>
    function checkLoginAndUpload() {
        @guest
            // Navigate to services section
            document.getElementById('servicesAnchor').click();
        @else
            // Trigger file input click event
            document.getElementById('imageUpload').click();
        @endguest
    }

    document.getElementById('upload-form').addEventListener('submit', function(event) {
        if (!checkLogin()) {
            event.preventDefault(); // Prevent form submission
        }
    });

    function checkLogin() {
        @guest
            // Show services section
            document.getElementById('services').style.display = 'block';
            return false; // Prevent form submission
        @else
            return true; // Allow form submission
        @endguest
    }

    function displayImageName() {
        const input = document.getElementById('imageUpload');
        const imageNameDisplay = document.getElementById('imageNameDisplay');
        const imageName = document.getElementById('imageName');

        if (input.files && input.files[0]) {
            imageName.textContent = input.files[0].name;
            imageNameDisplay.style.display = 'block';
        }
    }
</script>

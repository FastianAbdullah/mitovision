<div class="container mt-5">
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
                <form action="/upload-image" method="post" enctype="multipart/form-data" id="upload-form">
                    @csrf <!-- CSRF token -->
        
                    <!-- First Row: Patient ID and Patient Name -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="patientId" class="form-label">Patient ID</label>
                            <input type="text" class="form-control" id="patientId" name="patient_id" required>
                        </div>
                        <div class="col-md-6">
                            <label for="patientName" class="form-label">Patient Name</label>
                            <input type="text" class="form-control" id="patientName" name="patient_name" required>
                        </div>
                    </div>
        
                    <!-- Second Row: Gender and Blood Group -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="gender" name="gender" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bloodGroup" class="form-label">Blood Group</label>
                            <input type="text" class="form-control" id="bloodGroup" name="blood_group" required>
                        </div>
                    </div>
        
                    <!-- Upload Image Button -->
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <input type="file" class="form-control" id="imageUpload" name="image" style="display:none;" required onchange="displayImageName()">
                        <button type="button" class="btn btn-secondary" onclick="checkLoginAndUpload()">Select Image</button>
                    </div>
        
                    <!-- Display Uploaded Image Name -->
                    <div id="imageNameDisplay" class="mb-3" style="display:none;">
                        <strong>Uploaded Image:</strong> <span id="imageName"></span>
                    </div>
        
                    <!-- Get Prediction Button -->
                    <button type="submit" class="btn btn-primary">Get Prediction</button>
                </form>
                <!-- Prediction Outputs -->
                @if (isset($outputs))
                    <div class="mt-3">
                        <strong>Output:</strong>
                        <div class="bar-container">
                            @php $total = array_sum(array_values($outputs)); @endphp
                            @php $categories = array_keys($outputs); @endphp
                            @php $percentages = array_values($outputs); @endphp
                            @for ($i = 0; $i < count($outputs); $i++)
                                <div class="bar-item">
                                    <div class="bar-label" style="position: absolute; left: 170px;">
                                        @if ($categories[$i] == 0)
                                            Mitosis
                                        @elseif($categories[$i] == 1)
                                            Normal
                                        @else
                                            {{ $categories[$i] }}
                                        @endif
                                    </div>
                                    <div class="bar"
                                        style="width: {{ ($percentages[$i] / $total) * 200 }}%; margin-bottom: 10px; height: 20px; background-color: {{ $categories[$i] == 0 ? '#ff6347' : ($categories[$i] == 1 ? '#98fb98' : '#007BFF') }}; margin-right: 10px; border-radius: 2px; transition: width 0.3s ease-in-out;">
                                        <div class="bar-percentage"
                                            style="font-size: 14px; color: #000000; position: absolute; right: 170px;">
                                            {{ round($percentages[$i] * 100) }}%</div>
                                        <br><br>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                @endif

                <!-- Prediction Result -->
                @if (isset($result))
                    <div class="alert alert-info mt-3">
                        <strong>Result:</strong> This image is highly likely to be <strong>
                            {{ $result }}</strong>.
                    </div>
                @endif
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

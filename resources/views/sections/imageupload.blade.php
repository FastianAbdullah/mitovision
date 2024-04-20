<div class="container mt-5">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
            <!-- Static Image -->
            <img src="images/mitosis.jpg" class="img-fluid" alt="Static Image">
        </div>

        <!-- Right Column -->
        <div class="col-md-6">
            <!-- Upload Image Form -->
            <form action="/upload-image" method="post" enctype="multipart/form-data" id="upload-form">
                @csrf <!-- CSRF token -->
                
                <!-- Upload Image Button -->
                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Upload Image</label>
                    <input type="file" class="form-control-file" id="imageUpload" name="image">
                </div>

                <!-- Get Prediction Button -->
                <button type="submit" class="btn btn-primary">Get Prediction</button>
            </form>
        </div>
    </div>
</div>
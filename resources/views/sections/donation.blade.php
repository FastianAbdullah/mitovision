{{-- <div class="container mx-auto">
    <section class="overflow-hidden relative flex-col justify-center items-start px-14 pt-24 pb-64 mt-16 max-w-full text-6xl font-medium leading-[96px] min-h-[468px] text-stone-950 w-[1376px] max-md:px-5 max-md:pb-10 max-md:mt-10 max-md:max-w-full max-md:text-4xl">
        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/988045ce957158de29a3975ba5489bcc6dff83bcb07f5ae92a34e64cf6cbb8c7?apiKey=641235f4e38443deba41756493fa0b4d&" alt="Background image" class="object-cover absolute inset-0 size-full" />
        Donation For Cancerous Patients
    </section>
</div> --}}

<div id="intro" class="basic-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="text-container">
                    <div class="section-title">Donation</div>
                    <h2>Help other People</h2>
                    <p>Make a small donation to help people in need.</p>
                    <div>
                        <form action="{{route('donate')}}" method="POST">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" id="donationAmount" name="donationAmount" step="0.01" min="0" placeholder="Enter amount" required>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control" id="currency" name="currency" required>
                                        <option value="usd">USD</option>
                                        <option value="eur">EUR</option>
                                        <option value="gbp">GBP</option>
                                        <!-- Add more options for different currencies as needed -->
                                    </select>
                                </div>
                            </div>
                            <button class="btn-solid-reg page-scroll" type="submit" id="checkout-live-button">CheckOut</button>
                        </form>
                    </div>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
            <div class="col-lg-7">
                <div class="image-container" style="position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);">
                    <img class="img-fluid" src="images/Donation.jpg" alt="alternative" style="width: 100%; height: auto; display: block; transition: transform 0.3s ease-in-out;">
                </div> <!-- end of image-container -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of basic-1 -->

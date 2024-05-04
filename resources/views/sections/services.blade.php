<div id="services" class="cards-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">Pricing and Plans</div>
            <h2>Choose The Service Package<br> That Suits Your Needs</h2>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">
                <!-- dynamic Layout of Plans -->
                @foreach($plans as $plan)
                    <!-- Card -->
                    <div class="card">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{$plan['image_path']}}" class="img-fluid w-50" alt="Responsive image">
                        </div>
                        {{-- <div class="card-image">
                            <img class="img-fluid w-50" src="{{$plan['image_path']}}" alt="alternative">
                        </div> --}}
                        <div class="card-body">
                            <h3 class="card-title">{{$plan['plan']}} Plan</h3>
                            <p>{{$plan['description']}}</p>
                            <ul class="list-unstyled li-space-lg">
                                <li class="media">
                                    <i class="fas fa-square"></i>
                                    <div class="media-body">{{$plan['heading']}}</div>
                                </li>
                                <li class="media">
                                    <i class="fas fa-square"></i>
                                    <div class="media-body">Upload {{$plan['max_images']}} images monthly</div>
                                </li>
                            </ul>
                            <p class="price">Starting at <span>&#163;{{$plan['price']}} / mo</span></p>
                        </div>
                        <div class="button-container">
                            @if($plan['id'] == 1)
                                <a href="{{ route('register') }}" class="btn-solid-reg page-scroll">Sign Up for Free</a>
                            @else
                                <form action="{{ route('session' , ['id' => $plan['id'] ]) }}" method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <button class="btn-solid-reg page-scroll" type="submit" id="checkout-live-button">Subscribe Now</button>
                                </form>
                            @endif
                        </div> <!-- end of button-container -->
                    </div>
                    <!-- end of layout -->
                @endforeach
                
                <!-- end of card -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-2 -->

<script>
    $(document).ready(function(){
        $('#checkout-live-button').on('click',function(){
        })
    });
</script>
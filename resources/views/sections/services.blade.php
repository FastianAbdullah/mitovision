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
                @foreach($plans as $plan)
                    <!-- Card -->
                    <div class="card">
                        <div class="card-image">
                            <img class="img-fluid" src="images/services-1.jpg" alt="alternative">
                        </div>
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
                            <p class="price">Starting at <span>{{$plan['price']}} / mo</span></p>
                        </div>
                        <div class="button-container">
                            @if($plan['id'] == 1)
                                <a href="{{ route('register') }}" class="btn-solid-reg page-scroll">Sign Up for Free</a>
                            @else
                                {{-- <a class="btn-solid-reg page-scroll" href="{{route('session')}}">Subscribe Now</a> --}}
                                <form action="{{ route('session') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <button class="btn-solid-reg page-scroll" type="submit" id="checkout-live-button">Subscribe Now</button>
                                </form>
                            @endif
                        </div> <!-- end of button-container -->
                    </div>
                @endforeach
                
                <!-- end of card -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-2 -->
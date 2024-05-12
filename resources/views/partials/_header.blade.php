<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark navbar-custom fixed-top">
    <!-- Image Logo -->
    <a class="navbar-brand logo-image" href="index.html">Abdullah</a>
    
    <!-- Mobile Menu Toggle Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-awesome fas fa-bars"></span>
        <span class="navbar-toggler-awesome fas fa-times"></span>
    </button>
    <!-- end of mobile menu toggle button -->

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#header">HOME <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#intro">INTRO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#services">SERVICES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#upload">PREDICT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link page-scroll" href="#testimonials">TESTIMONIALS</a>
            </li>
            <!-- end of dropdown menu -->

            <li class="nav-item">
                <a class="nav-link page-scroll" href="#footer">CONTACT</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle page-scroll" href="#profile" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle" src="{{asset('images/undraw_profile.svg')}}" style="width: 30; height: 30px;">
                </a>
                
                @if(Auth::check())
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('doctor.dashboard') }}"><span class="item-text">Dashboard</span></a>
                   
                        <div class="dropdown-items-divide-hr"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="item-text">Logout</span></a>
                @endif
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- end of navbar -->

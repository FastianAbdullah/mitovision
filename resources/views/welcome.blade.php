@extends('layouts.app')

@section('content')

    @include('sections.banner')

    <!-- Intro -->

    @include('sections.intro')
    
    <!-- end of intro -->

    @include('sections.imageupload')
    
    <!-- Services -->
    @include('sections.services')
   
    <!-- end of services -->

    <!-- Testimonials -->

    @include('sections.testimonials')


    @include('sections.donation')

@endsection
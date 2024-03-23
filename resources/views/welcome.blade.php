@extends('layouts.app')

@section('content')

    @include('sections.banner')

    <!-- Intro -->

    @include('sections.intro')
    
    <!-- end of intro -->

    <!-- Services -->
    @include('sections.services')
   
    <!-- end of services -->


    <!-- Details Tab -->
    {{-- @include('sections.details') --}}
   
    <!-- end of services -->
    

    <!-- Testimonials -->

    @include('sections.testimonials')

    <!-- end of testimonials -->


    <!-- Call Me -->

    {{-- @include('sections.contact') --}}
    
    <!-- end of call me -->


    <!-- Projects -->

    {{-- @include('sections.projects') --}}
	
    <!-- end of projects -->

    <!-- Team -->
    {{-- @include('sections.team') --}}
    
    <!-- end of team -->


    <!-- About -->
    @include('sections.about')
   
    <!-- end of about -->


    <!-- Contact -->
    @include('sections.contact-form')
   
    <!-- end of contact -->


@endsection